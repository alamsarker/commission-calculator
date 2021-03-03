<?php

declare(strict_types=1);

namespace App\Tests\Libraries\Commission\Rules;

use PHPUnit\Framework\TestCase;
use App\Libraries\{
    Readers\CsvFileReader,
    Cache\ArrayCache,
    CurrencyConverter\CurrencyConverter,
    Commission\Rules\PrivateWithdrawRule,
    Commission\Config,
    Commission\Operation,
    Formatters\RoundedUpFormatter,
};

final class PrivateWithdrawRuleTest extends TestCase
{
    /**
     * Calculate commission with free of charge
     */
    public function testGetCommissionWithFreeCharge()
    {
        $operation = new Operation(
            new \DateTime(),
            100,
            'private', 
            'withdraw', 
            1000, 
            'EUR'
        );   
        
        $config = new Config();
        $config
            ->setPrivateWithdrawRate(0.3)
            ->setPrivateWithdrawMaxTimes(3)
            ->setPrivateWithdrawMaxLimit(1000)
            ->setCurrency([])
            ;
        $converter = new CurrencyConverter($config->getCurrency());
        $cache = new ArrayCache();
        $formatter = new RoundedUpFormatter();

        $rule = new PrivateWithdrawRule(
            $converter,
            $config,
            $cache,
            $formatter
        );       

        $commission = $rule->getCommission($operation);
        $this->assertEquals(0, $commission);         
    } 
    
    /**
     * Calculate commission for remaining amount after reducing the free commission
     */
    public function testGetCommissionForRemainingAmount()
    {
        $operation = new Operation(
            new \DateTime(),
            1001,
            'private', 
            'withdraw', 
            1200, 
            'EUR'
        );
        
        $config = new Config();
        $config
            ->setPrivateWithdrawRate(0.3)
            ->setPrivateWithdrawMaxTimes(3)
            ->setPrivateWithdrawMaxLimit(1000)
            ->setCurrency([])
            ;
        $converter = new CurrencyConverter($config->getCurrency());
        $cache = new ArrayCache();
        $formatter = new RoundedUpFormatter();

        $rule = new PrivateWithdrawRule(
            $converter,
            $config,
            $cache,
            $formatter
        );       

        $commission = $rule->getCommission($operation);
        $this->assertEquals(0.60, $commission);         
    } 
}
