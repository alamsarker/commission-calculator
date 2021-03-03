<?php

declare(strict_types=1);

namespace App\Libraries\Formatters;

final class RoundedUpFormatter implements FormatterInterface
{
    /**
     * Used to making decimal round
     * 
     * @param mixed $value
     * @return string
     */
    public function format($value): string
    {
        $mult = pow(10, 2);
        $rounded = ceil($value * $mult) / $mult;        

        return number_format((float)$rounded, 2, '.', '');        
    }
}