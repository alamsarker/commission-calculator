<?php

declare(strict_types=1);

namespace App\Tests\Libraries\Commission\Rules;

use PHPUnit\Framework\TestCase;
use App\Libraries\{    
    Cache\ArrayCache,
    CurrencyConverter\CurrencyConverter,
    Commission\Rules\DepositRule,
    Commission\Config,
    Commission\Operation,
    Formatters\RoundedUpFormatter,
};

final class DepositRuleTest extends TestCase
{
    /**
     * Calculate commission for private deposit
     */
    public function testGetCommissionForPrivateDeposit()
    {
        $operation = new Operation(
            new \DateTime(),
            101,
            'private', 
            'deposit', 
            200.00, 
            'EUR'
        );   
        
        $config = new Config();
        $config
            ->setDepositRate(0.03)
            ->setCurrency([])
            ;

        $converter = new CurrencyConverter($config->getCurrency());
        $cache = new ArrayCache();
        $formatter = new RoundedUpFormatter();

        $rule = new DepositRule(
            $converter,
            $config,
            $cache,
            $formatter
        );       

        $commission = $rule->getCommission($operation);
        $this->assertEquals(0.06, $commission);         
    } 
    
    /**
     * Calculate commission for business deposit
     */
    public function testGetCommissionForBusinessDeposit()
    {
        $operation = new Operation(
            new \DateTime(),
            102,
            'business', 
            'withdraw', 
            10000.00, 
            'EUR'
        );
        
        $config = new Config();
        $config
            ->setDepositRate(0.03)
            ->setCurrency([])
            ;

        $converter = new CurrencyConverter($config->getCurrency());
        $cache = new ArrayCache();
        $formatter = new RoundedUpFormatter();

        $rule = new DepositRule(
            $converter,
            $config,
            $cache,
            $formatter
        );       

        $commission = $rule->getCommission($operation);
        $this->assertEquals(3.00, $commission);         
    } 
}
