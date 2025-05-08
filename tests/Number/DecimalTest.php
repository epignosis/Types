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
        $this->expectExceptionMessage('Value is not numeric.');
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
        $decimal = new Decimal(12.345, 16, PHP_ROUND_HALF_UP);

        $this->assertEquals(12.345, $decimal->getValue());
        $this->assertEquals(16, $decimal->getPrecision());
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

    public function test_RoundingThrowsExceptionOnInvalidHigherValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Decimal(12.345, 2, 5);
    }

    public function test_RoundingThrowsExceptionOnInvalidLowerValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Decimal(12.345, 2, 0);
    }

    public function test_PrecisionThrowsExceptionWhenTooHigh(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Precision must be greater than -1 and less than or equal to 16.");
        new Decimal(2, 17);
    }

    public function test_PrecisionThrowsExceptionWhenTooLow(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Precision must be greater than -1 and less than or equal to 16.");
        new Decimal(2, -1);
    }

    public function test_FromNumericPrecisionThrowsExceptionWhenTooLow(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Precision must be greater than -1 and less than or equal to 16.");
        Decimal::fromNumeric(2, -1);
    }

    public function test_FromNumericPrecisionThrowsExceptionWhenTooHigh(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Precision must be greater than -1 and less than or equal to 16.");
        Decimal::fromNumeric(2, 17);
    }

    public function test_FromNumericPrecisionThrowsExceptionWhenMinimumZeroAndValueZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Precision must be greater than 0 and less than or equal to 16.");
        Decimal::fromNumeric(0, -12);
    }

    public function test_MinimumPrecisionIsZeroWhenGivenZeroAsValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Precision must be greater than 0 and less than or equal to 16.");
        new Decimal(0, -12);
    }

    public function test_PrecisionFailsWhenBelowMinimumBasedOnFloor(): void
    {
        $value = 9.99;
        $this->expectException(InvalidArgumentException::class);
        new Decimal($value, -1);
    }

    public function test_PrecisionPassesWhenJustAboveMinimumBasedOnFloor(): void
    {
        $value = 9.99;
        $decimal = new Decimal($value, 0);
        $this->assertEquals(round(9.99, 0), $decimal->getValue());
    }

    public function test_FromNumericMinimumPrecisionIsZeroWhenGivenZeroAsValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Precision must be greater than 0 and less than or equal to 16.");
        Decimal::fromNumeric(0, -12);
    }

    public function test_FromNumericPrecisionFailsWhenBelowMinimumBasedOnFloor(): void
    {
        $value = 9.99;
        $this->expectException(InvalidArgumentException::class);
        Decimal::fromNumeric($value, -1);
    }

    public function test_FromNumericPrecisionPassesWhenJustAboveMinimumBasedOnFloor(): void
    {
        $value = 9.99;
        $decimal = Decimal::fromNumeric($value, 0);
        $this->assertEquals(round(9.99, 0), $decimal->getValue());
    }

    public function test_FromNumericRoundingValues(): void
    {
        $decimal = Decimal::fromNumeric(12.345, 2, PHP_ROUND_HALF_UP);
        $this->assertEquals(12.35, $decimal->getValue());
        $this->assertEquals(1, $decimal->getRounding());

        $decimal = Decimal::fromNumeric(12.345, 2, PHP_ROUND_HALF_DOWN);
        $this->assertEquals(12.34, $decimal->getValue());
        $this->assertEquals(2, $decimal->getRounding());

        $decimal = Decimal::fromNumeric(12.345, 2, PHP_ROUND_HALF_EVEN);
        $this->assertEquals(12.34, $decimal->getValue());
        $this->assertEquals(3, $decimal->getRounding());

        $decimal = Decimal::fromNumeric(12.345, 2, PHP_ROUND_HALF_ODD);
        $this->assertEquals(12.35, $decimal->getValue());
        $this->assertEquals(4, $decimal->getRounding());
    }

    public function test_FromNumericRoundingThrowsExceptionOnInvalidHigherValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Decimal::fromNumeric(12.345, 2, 5);
    }

    public function test_FromNumericRoundingThrowsExceptionOnInvalidLowerValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Decimal::fromNumeric(12.345, 2, 0);
    }
}
