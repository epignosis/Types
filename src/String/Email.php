<?php

declare(strict_types=1);

namespace Epignosis\Types\String;

use Epignosis\Types\AbstractType;
use InvalidArgumentException;

class Email extends AbstractType
{
    private string $value;

    public function __construct(string $value)
    {
        /** @var string|null $value */
        $value = filter_var($value, \FILTER_SANITIZE_EMAIL, \FILTER_NULL_ON_FAILURE);

        if (!is_string($value) || !filter_var($value, \FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email is invalid');
        }

        $this->value = $value;
    }

    final public function getValue(): string
    {
        return $this->value;
    }
}
