<?php

declare(strict_types=1);

namespace Epignosis\Types\Tests\String;

use Epignosis\Types\String\Email;
use Epignosis\Types\String\NonEmptyString;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function test_CanBeCreatedFromEmail(): void
    {
        $result = (new Email('hello@example.com'))->getValue();

        $this->assertEquals('hello@example.com', $result);
    }

    public function test_CannotBeCreatedFromInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Email('yrizos at example.com');
    }

    public function test_IsEqualToSameTypeWithSameValue(): void
    {
        $integer1 = new Email('hello@example.com');
        $integer2 = new Email('hello@example.com');

        $this->assertTrue($integer1->equals($integer2));
        $this->assertTrue($integer2->equals($integer1));
    }

    public function test_IsNotEqualToSameTypeWithDifferentValue(): void
    {
        $integer1 = new Email('hello@example.com');
        $integer2 = new Email('world@example.com');

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }

    public function test_isNotEqualToDifferentType(): void
    {
        $integer1 = new Email('hello@example.com');
        $integer2 = new NonEmptyString('hello@example.com');

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }
}
