<?php

declare(strict_types=1);

namespace Epignosis\Types\String;

use Epignosis\Types\AbstractType;
use InvalidArgumentException;

class NonEmptyString extends AbstractType
{
    private string $value;

    public function __construct(string $value)
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException('Value must not be empty');
        }

        $this->value = $value;
    }

    final public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param scalar $value
     * @return static
     *
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    final public static function fromScalar($value): self
    {
        if (is_scalar($value)) {
            return new self((string)$value);
        }

        throw new InvalidArgumentException('Value is not scalar.');
    }
}
