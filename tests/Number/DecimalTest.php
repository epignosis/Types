<?php

declare(strict_types=1);

namespace Epignosis\Types\Tests\Number;

use Epignosis\Types\Number\Integer;
use PHPUnit\Framework\TestCase;
use Epignosis\Types\Number\Decimal;
use InvalidArgumentException;

/**
 * @covers \Epignosis\Types\Number\Decimal
 */
final class DecimalTest extends TestCase
{
    public function test_CanBeCreatedFromFloatWithDefaultPrecision(): void
    {
        $result = (new Decimal(12.3456))->getValue();

        $this->assertEqualsWithDelta(12.35, $result, 0.00001);
    }

    public function test_CanBeCreatedFromFloat(): void
    {
        $result = (new Decimal(12.345, 1))->getValue();

        $this->assertEqualsWithDelta(12.3, $result, 0.00001);
    }

    public function test_canBeCreatedFromFloatString(): void
    {
        $result = Decimal::fromNumeric('12.345')->getValue();

        $this->assertEqualsWithDelta(12.35, $result, 0.00001);
    }

    public function test_canBeCreatedFromInteger(): void
    {
        $result = Decimal::fromNumeric(12.3)->getValue();

        $this->assertEqualsWithDelta(12.3, $result, 0.00001);
    }

    public function test_canNotBeCreatedFromNonNumeric(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Decimal::fromNumeric('abc');
    }

    public function test_IsEqualToSameTypeWithSameValue(): void
    {
        $float1 = new Decimal(12.345);
        $float2 = new Decimal(12.345);

        $this->assertTrue($float1->equals($float2));
        $this->assertTrue($float2->equals($float1));
    }

    public function test_IsNotEqualToSameTypeWithDifferentValue(): void
    {
        $float1 = new Decimal(12.345, 3);
        $float2 = new Decimal(12.346, 3);

        $this->assertFalse($float1->equals($float2));
        $this->assertFalse($float2->equals($float1));
    }

    public function test_IsNotEqualToSameTypeWithDifferentType(): void
    {
        $float1 = new Decimal(12, 0);
        $integer = new Integer(12);

        $this->assertFalse($float1->equals($integer));
        $this->assertFalse($integer->equals($float1));
    }

    public function test_GetMethods(): void
    {
        $decimal = new Decimal(12.345, 2, PHP_ROUND_HALF_UP);

        $this->assertEquals(12.35, $decimal->getValue());
        $this->assertEquals(2, $decimal->getPrecision());
        $this->assertEquals(1, $decimal->getRounding());
    }

    public function test_RoundingValues(): void
    {
        $decimal = new Decimal(12.345, 2, PHP_ROUND_HALF_UP);
        $this->assertEquals(12.35, $decimal->getValue());
        $this->assertEquals(1, $decimal->getRounding());

        $decimal = new Decimal(12.345, 2, PHP_ROUND_HALF_DOWN);
        $this->assertEquals(12.34, $decimal->getValue());
        $this->assertEquals(2, $decimal->getRounding());

        $decimal = new Decimal(12.345, 2, PHP_ROUND_HALF_EVEN);
        $this->assertEquals(12.34, $decimal->getValue());
        $this->assertEquals(3, $decimal->getRounding());

        $decimal = new Decimal(12.345, 2, PHP_ROUND_HALF_ODD);
        $this->assertEquals(12.35, $decimal->getValue());
        $this->assertEquals(4, $decimal->getRounding());
    }
}
