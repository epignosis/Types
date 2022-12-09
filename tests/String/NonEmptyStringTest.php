<?php

declare(strict_types=1);

namespace Epignosis\Types\Tests\String;

use Epignosis\Types\String\Email;
use Epignosis\Types\String\NonEmptyString;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class NonEmptyStringTest extends TestCase
{
    public function test_CanBeCreatedFromString(): void
    {
        $result = (new NonEmptyString('Hello'))->getValue();

        $this->assertEquals('Hello', $result);
    }

    public function test_CanBeCreatedFromInteger(): void
    {
        $result = NonEmptyString::fromScalar(42)->getValue();

        $this->assertEquals('42', $result);
    }

    public function test_CanBeCreatedFromFloat(): void
    {
        $result = NonEmptyString::fromScalar(42.5)->getValue();

        $this->assertEquals('42.5', $result);
    }

    public function test_CanBeCreatedFromBoolean(): void
    {
        $result = NonEmptyString::fromScalar(true)->getValue();

        $this->assertEquals('1', $result);
    }

    public function test_CannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new NonEmptyString('');
    }

    public function test_CannotBeCreatedFromWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new NonEmptyString('    ');
    }

    public function test_IsEqualToSameTypeWithSameValue(): void
    {
        $integer1 = new NonEmptyString('Hello');
        $integer2 = new NonEmptyString('Hello');

        $this->assertTrue($integer1->equals($integer2));
        $this->assertTrue($integer2->equals($integer1));
    }

    public function test_IsNotEqualToSameTypeWithDifferentValue(): void
    {
        $integer1 = new NonEmptyString('Hello');
        $integer2 = new NonEmptyString('World');

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }

    public function test_isNotEqualToDifferentType(): void
    {
        $integer1 = new NonEmptyString('hello@example.com');
        $integer2 = new Email('hello@example.com');

        $this->assertFalse($integer1->equals($integer2));
        $this->assertFalse($integer2->equals($integer1));
    }
}
