<?php

declare(strict_types=1);

namespace App\Libraries\CurrencyConverter;

abstract class AbstractCurrencyConverter
{
    /**
     * Constuctor
     * 
     * @param array $rates Currency convertion rating
     */
    public function __construct(protected array $rates){}

    /**
     * Convert currency from one to another
     * 
     * @param sting $from From Currency like EUR
     * @param string $to converted to this curency
     * @return float
     */
    abstract public function convert(string $from, string $to, float $amount): float;
}