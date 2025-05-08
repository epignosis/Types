<?php

declare(strict_types=1);

namespace Epignosis\Types\Tests\Number;

use PHPUnit\Framework\TestCase;
use Epignosis\Types\Number\NonNegativeDecimal;
use InvalidArgumentException;
use Epignosis\Types\Number\Decimal;

/**
 * @covers \Epignosis\Types\Number\NonNegativeDecimal
 */
final class NonNegativeDecimalTest extends TestCase
{
    public function test_CanBeCreatedFromPositiveDecimal(): void
    {
        $result = (new NonNegativeDecimal(12.345))->getValue();

        $this->assertEqualsWithDelta(12.35, $result, 0.00001);
    }

    public function test_CanBeCreatedFromZero(): void
    {
        $result = (new NonNegativeDecimal(0))->getValue();

        $this->assertEqualsWithDelta(0.0, $result, 0.00001);
    }

    public function test_canBeCreatedFromNumericString(): void
    {
        $result = NonNegativeDecimal::fromNumeric('12.345')->getValue();

        $this->assertEqualsWithDelta(12.35, $result, 0.00001);
    }

    public function test_canBeCreatedFromFloat(): void
    {
        $result = NonNegativeDecimal::fromNumeric(12.34)->getValue();

        $this->assertEqualsWithDelta(12.34, $result, 0.00001);
    }

    public function test_canBeCreatedFromZeroFromNumeric(): void
    {
        $result = NonNegativeDecimal::fromNumeric(0)->getValue();

        $this->assertEqualsWithDelta(0, $result, 0.00001);
    }

    public function test_canNotBeCreatedFromNegativeUsingNumericFloat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value must be a non-negative decimal number.');

        NonNegativeDecimal::fromNumeric(-12.34);
    }

    public function test_canNotBeCreatedFromNonNumeric(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value is not numeric.');

        NonNegativeDecimal::fromNumeric('abc');
    }

    public function test_CannotBeCreatedFromNegativeFloat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value must be a non-negative decimal number.');

        new NonNegativeDecimal(-12.34);
    }

    public function test_IsEqualToSameTypeWithSameValue(): void
    {
        $float1 = new NonNegativeDecimal(12.34);
        $float2 = new NonNegativeDecimal(12.34);

        $this->assertTrue($float1->equals($float2));
        $this->assertTrue($float2->equals($float1));
    }

    public function test_IsNotEqualToSameTypeWithDifferentValue(): void
    {
        $float1 = new NonNegativeDecimal(12.34);
        $float2 = new NonNegativeDecimal(12.35);

        $this->assertFalse($float1->equals($float2));
        $this->assertFalse($float2->equals($float1));
    }

    public function test_isNotEqualToDifferentType(): void
    {
        $float1 = new NonNegativeDecimal(12.34);
        $float2 = new Decimal(12.34);

        $this->assertFalse($float1->equals($float2));
        $this->assertFalse($float2->equals($float1));
    }
}
