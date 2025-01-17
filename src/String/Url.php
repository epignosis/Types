<?php

namespace Epignosis\Types\String;

use Epignosis\Types\AbstractType;
use InvalidArgumentException;

class Url extends AbstractType
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        /** @var string|null $value */
        $value = filter_var($value, \FILTER_SANITIZE_URL, \FILTER_NULL_ON_FAILURE);

        if (!is_string($value) || !filter_var($value, \FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Url is invalid');
        }

        $this->value = $value;
    }

    final public function getValue(): string
    {
        return $this->value;
    }
}