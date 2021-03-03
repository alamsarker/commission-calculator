<?php

declare(strict_types=1);

namespace App\Libraries\Commission\Rules;

use App\Libraries\{
    Commission\Operation,
    Commission\Config,
    Cache\CacheInterface,
    CurrencyConverter\AbstractCurrencyConverter,
    Formatters\FormatterInterface,
};

abstract class AbstractRule
{    
    /**
     * Constructor
     * 
     * @param AbstractCurrencyConverter $currencyConverter
     * @param Config $config
     * @param CacheInterface $cache
     * @param FormatterInterface $formatter
     */
    public function __construct(
        protected AbstractCurrencyConverter $currencyConverter,
        protected Config $config,
        protected CacheInterface $cache,
        protected FormatterInterface $formatter
    ){}


    /**
     * Check whether the currency is Euro
     * 
     * @param Operation $operation The operation input 
     * @return bool 
     */
    protected function isEuro(Operation $operation): bool
    {
        return $operation->getCurrency() == 'EUR';
    }
    

    /**
     * Get the client Key for preserve weekly cached data
     * 
     * @param Operation $operation Input param is used to prepare prefix cache key, used to prepare key prefix
     * @param string $key Actual key name
     * @return string
     */
    protected function getKey(Operation $operation, string $key): string
    {
        $weekNumber = $operation->getTransDate()->format('oW');
        $userId = $operation->getUserId();

        return $weekNumber . '_' . $userId . '_' . $key;        
    }
    

    /**
     * Commission will be calculated by this method.
     * 
     * @param Operation $operation
     * @return string
     */
    abstract public function getCommission(Operation $operation): string;
}