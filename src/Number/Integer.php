<?php

declare(strict_types=1);

namespace Epignosis\Types\Number;

use Epignosis\Types\AbstractType;
use InvalidArgumentException;

class Integer extends AbstractType
{
    private int $value;

    final public function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    final public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int|float|string $value
     * @return static
     */
    final public static function fromNumeric($value): static
    {
        if (is_numeric($value)) {
            return new static((int)$value);
        }

        throw new InvalidArgumentException('Value is not numeric.');
    }

    protected function validate(int $value): void
    {
        // Integer does nothing.
    }
}
