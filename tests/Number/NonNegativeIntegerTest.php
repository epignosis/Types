<?php

declare(strict_types=1);

namespace Epignosis\Types\Tests\Number;

use Epignosis\Types\Number\Integer;
use Epignosis\Types\Number\NonNegativeInteger;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class NonNegativeIntegerTest extends TestCase
{
    public function test_CanBeCreatedFromPositiveInteger(): void
    {
        $result = (new NonNegativeInteger(42))->getValue();

        $this->assertEquals(42, $result);
    }

    public function test_CanBeCreatedFromZero(): void
    {
        $result = (new NonNegativeInteger(0))->getValue();

        $this->assertEquals(0, $result);
    }

    public function test_canBeCreatedFromNumericString(): void
    {
        $result = NonNegativeInteger::fromNumeric('42')->getValue();

        $this->assertEquals(42, $result);
    }

    public function test_canBeCreatedFromFloat(): void
    {
        $result = NonNegativeInteger::fromNumeric(42.3)->getValue();

        $this->assertEquals(42, $result);
    }

    public function test_CannotBeCreatedFromNegativeInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new NonNegativeInteger(-1);
    }

    public function test_IsEqualToSameTypeWithSameValue(): void
    {
        $integer1 = new NonNegativeInteger(42);
        $integer2 = new NonNegativeInteger(42);

        $this->assertTrue($integer1->equals($integer2));
        $this->assertTrue($integer2->equals($integer1));
    }

    public function test_IsNotEqualToSameTypeWithDifferentValue(): void
    {
        $integer1 = new NonNegativeInteger(1000);
        $integer2 = new NonNegativeInteger(1024);

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }

    public function test_isNotEqualToDifferentType(): void
    {
        $integer1 = new NonNegativeInteger(42);
        $integer2 = new Integer(42);

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }
}
