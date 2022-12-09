<?php

declare(strict_types=1);

namespace Epignosis\Types\Tests\Number;

use Epignosis\Types\Number\Integer;
use Epignosis\Types\Number\PositiveInteger;
use PHPUnit\Framework\TestCase;

final class IntegerTest extends TestCase
{
    public function test_CanBeCreatedFromInteger(): void
    {
        $result = (new Integer(42))->getValue();

        $this->assertEquals(42, $result);
    }

    public function test_canBeCreatedFromNumericString(): void
    {
        $result = Integer::fromNumeric('42')->getValue();

        $this->assertEquals(42, $result);
    }

    public function test_canBeCreatedFromFloat(): void
    {
        $result = Integer::fromNumeric(42.3)->getValue();

        $this->assertEquals(42, $result);
    }

    public function test_IsEqualToSameTypeWithSameValue(): void
    {
        $integer1 = new Integer(42);
        $integer2 = new Integer(42);

        $this->assertTrue($integer1->equals($integer2));
        $this->assertTrue($integer2->equals($integer1));
    }

    public function test_IsNotEqualToSameTypeWithDifferentValue(): void
    {
        $integer1 = new Integer(1000);
        $integer2 = new Integer(1024);

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }

    public function test_isNotEqualToDifferentType(): void
    {
        $integer1 = new Integer(42);
        $integer2 = new PositiveInteger(42);

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }
}
