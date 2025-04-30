<?php

declare(strict_types=1);

namespace Epignosis\Types\Number;

use Epignosis\Types\AbstractType;
use InvalidArgumentException;

class Decimal extends AbstractType
{
    private float $value;

    private int $precision;

    private int $rounding;

    /**
     * @param  float  $value
     * @param  int  $precision  < max : 16>
     * @param  int  $rounding  (1 : PHP_ROUND_HALF_UP (Default), 2 : PHP_ROUND_HALF_DOWN,
     *                          3 : PHP_ROUND_HALF_EVEN, 4 : PHP_ROUND_HALF_ODD)
     */
    public function __construct(float $value, int $precision = 2, int $rounding = PHP_ROUND_HALF_UP)
    {
        if ($value == 0.0) {
            $minimumPrecision = 0;
        } else {
            $minimumPrecision = -(floor(log10(abs($value))) + 1);
        }

        if ($precision > 16 || $precision <= $minimumPrecision) {
            throw new InvalidArgumentException(
                "Precision must be greater than {$minimumPrecision} and less than or equal to 16."
            );
        }

        if ($rounding < 1 || $rounding > 4) {
            throw new InvalidArgumentException('Rounding must be between 1 and 4.');
        }

        $this->value = round($value, $precision, $rounding);
        $this->precision = $precision;
        $this->rounding = $rounding;
    }

    final public function getValue(): float
    {
        return $this->value;
    }

    final public function getPrecision(): int
    {
        return $this->precision;
    }

    final public function getRounding(): int
    {
        return $this->rounding;
    }

    /**
     * @param  int|float|string  $value
     * @param  int  $precision
     * @param  int  $rounding  (1 : PHP_ROUND_HALF_UP, 2 : PHP_ROUND_HALF_DOWN,
     *                          3 : PHP_ROUND_HALF_EVEN, 4 : PHP_ROUND_HALF_ODD)
     * @return self
     */
    public static function fromNumeric($value, int $precision = 2, int $rounding = PHP_ROUND_HALF_UP): self
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Value is not numeric.');
        }

        if ((float)$value == 0.0) {
            $minimumPrecision = 0;
        } else {
            $minimumPrecision = -(floor(log10(abs((float)$value))) + 1);
        }

        if ($precision > 16 || $precision <= $minimumPrecision) {
            throw new InvalidArgumentException(
                "Precision must be greater than {$minimumPrecision} and less than or equal to 16."
            );
        }

        if ($rounding < 1 || $rounding > 4) {
            throw new InvalidArgumentException('Rounding must be between 1 and 4.');
        }

        $value = round((float)$value, $precision, $rounding);
        return new self($value, $precision, $rounding);
    }
}
