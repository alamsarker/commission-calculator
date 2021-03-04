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
     * @var PrivateWithdrawRule
     */
    private $privateWithdrawRule;

    /**
     * Setup PrivateWithdrawRule
     */
    public function setUp(): void
    {
        $config = new Config();
        $converter = new CurrencyConverter($config->getCurrency());
        $cache = new ArrayCache();
        $formatter = new RoundedUpFormatter();

        $this->privateWithdrawRule = new PrivateWithdrawRule(
            $converter,
            $config,
            $cache,
            $formatter
        );
    }
    
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

        $commission = $this->privateWithdrawRule->getCommission($operation);
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

        $commission = $this->privateWithdrawRule->getCommission($operation);
        $this->assertEquals(0.60, $commission);         
    } 
}
