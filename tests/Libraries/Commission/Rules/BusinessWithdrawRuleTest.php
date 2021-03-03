<?php

declare(strict_types=1);

namespace App\Tests\Libraries\Commission\Rules;

use PHPUnit\Framework\TestCase;
use App\Libraries\{    
    Cache\ArrayCache,
    CurrencyConverter\CurrencyConverter,
    Commission\Rules\BusinessWithdrawRule,
    Commission\Config,
    Commission\Operation,
    Formatters\RoundedUpFormatter,
};

final class BusinessWithdrawRuleTest extends TestCase
{
    /**
     * Calculate commission for business withdraw
     */
    public function testGetCommissionForBusinessWithdraw()
    {
        $operation = new Operation(
            new \DateTime(),
            103,
            'private', 
            'deposit', 
            300.00, 
            'EUR'
        );
        
        $config = new Config();
        $config
            ->setBussinessWithdrawRate(0.5)
            ->setCurrency([])
            ;

        $converter = new CurrencyConverter($config->getCurrency());
        $cache = new ArrayCache();
        $formatter = new RoundedUpFormatter();

        $rule = new BusinessWithdrawRule(
            $converter,
            $config,
            $cache,
            $formatter
        );       

        $commission = $rule->getCommission($operation);
        $this->assertEquals(1.50, $commission);         
    }    
}
