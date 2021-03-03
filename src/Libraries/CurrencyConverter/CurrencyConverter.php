<?php

declare(strict_types=1);

namespace App\Libraries\CurrencyConverter;

class CurrencyConverter extends AbstractCurrencyConverter
{
    /**
     * Convert currency from one to another
     * 
     * @param sting $from From Currency like EUR
     * @param string $to converted to this curency
     * @return float
     */
    public function convert(string $from, string $to, float $amount): float
    {
        if($this->rates['base'] === $to && $amount > 0) {
            return $amount / $this->rates['rates'][$from];
        }

        return $amount;
    }

    /**
     * Revert to the previouse currency
     * 
     * @param sting $from From Currency like BDT
     * @param string $to revereted to this curency
     * @return float
     */
    public function revert(string $from, string $to, float $amount): float
    {
        if($this->rates['base'] === $from && $amount > 0) {
            return $amount * $this->rates['rates'][$to];
        }

        return $amount;
    }
}