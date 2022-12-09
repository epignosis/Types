<?php

declare(strict_types=1);

namespace Epignosis\Types\Tests\Number;

use Epignosis\Types\Number\Integer;
use Epignosis\Types\Number\PositiveInteger;
use Epignosis\Types\Number\PositivePositiveIntegerType;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class PositiveIntegerTest extends TestCase
{
    public function test_CanBeCreatedFromPositiveInteger(): void
    {
        $result = (new PositiveInteger(42))->getValue();

        $this->assertEquals(42, $result);
    }

    public function test_canBeCreatedFromNumericString(): void
    {
        $result = PositiveInteger::fromNumeric('42')->getValue();

        $this->assertEquals(42, $result);
    }

    public function test_canBeCreatedFromFloat(): void
    {
        $result = PositiveInteger::fromNumeric(42.3)->getValue();

        $this->assertEquals(42, $result);
    }

    public function test_CannotBeCreatedFromZero(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new PositiveInteger(0);
    }

    public function test_CannotBeCreatedFromNegativeInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new PositiveInteger(-1);
    }

    public function test_IsEqualToSameTypeWithSameValue(): void
    {
        $integer1 = new PositiveInteger(42);
        $integer2 = new PositiveInteger(42);

        $this->assertTrue($integer1->equals($integer2));
        $this->assertTrue($integer2->equals($integer1));
    }

    public function test_IsNotEqualToSameTypeWithDifferentValue(): void
    {
        $integer1 = new PositiveInteger(1000);
        $integer2 = new PositiveInteger(1024);

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }

    public function test_isNotEqualToDifferentType(): void
    {
        $integer1 = new PositiveInteger(42);
        $integer2 = new Integer(42);

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }
}
