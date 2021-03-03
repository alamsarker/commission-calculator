<?php

declare(strict_types=1);

namespace App\Tests\Libraries\Commission;

use PHPUnit\Framework\TestCase;
use App\Libraries\{
    Readers\CsvFileReader,
    Cache\ArrayCache,
    CurrencyConverter\CurrencyConverter,
    Commission\CommissionManager,
    Commission\Config,
    Formatters\RoundedUpFormatter,
};

final class CommissionManagerTest extends TestCase
{
    /**
     * @var CommissionManager
     */
    private $commissionManager;

    /**
     * Setup commission
     */
    public function setUp(): void
    {
        $config = new Config();
        $this->commissionManager = new CommissionManager(
            new CurrencyConverter($config->getCurrency()),
            $config,
            new ArrayCache(),
            new RoundedUpFormatter()
        ); 
    }

    /**     
     *
     * Calculate the commission for private and business client
     */
    public function testCalculator()
    {
        $csvFilePath = 'input.csv';
        $expected = [
            '0.60',
            '3.00',
            '0.00',
            '0.06',
            '1.50',
            '0.00',
            '0.70',
            '0.30',
            '0.30',
            '3.00',
            '0.00',
            '0.00',
            '8611.42',
        ];
       
        $actual = $this->commissionManager
            ->setReader(new CsvFileReader($csvFilePath))
            ->calculate()
            ;      
        
        foreach($expected as $key => $value) {           
            $this->assertEquals($value, $actual[$key]);            
        }        
    }    
}
