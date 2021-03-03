<?php

declare(strict_types=1);

namespace App\Libraries\Commission;

final class Config
{
    /**
     * @var float
     */
    private float $depositRate = 0.03;
    
    /**
     * @var float
     */
    private float $bussinessWithdrawRate = 0.5;

    /**
     * @var float
     */
    private float $privateWithdrawRate = 0.3;

    /**
     * @var int
     */
    private int $privateWithdrawMaxTimes = 3;

    /**
     * @var int
     */
    private int $privateWithdrawMaxLimit = 1000;

    /**
     * @var array
     */
    private array $currency = [        
        'rates' => [
            'USD' => 1.1497,
            'JPY' => 129.53
        ],
        'base' => 'EUR'
    ];

    /**
     * Set Default deposit commission rate
     * 
     * @param $depositRate
     * @param self
     */
    public function setDepositRate(float $depositRate): self 
    {
        $this->depositRate = $depositRate;

        return $this;
    }

    /**
     * Get default deposit commission rate
     * 
     * @return float
     */
    public function getDepositRate(): float 
    {
        return $this->depositRate;
    }

    /**
     * Set default business withdraw rate
     * 
     * @param float @bussinessWithdrawRate
     * @return self
     */
    public function setBussinessWithdrawRate(float $bussinessWithdrawRate): self 
    {
        $this->bussinessWithdrawRate = $bussinessWithdrawRate;

        return $this;
    }

    /**
     * Get detault business withdraw rating
     * 
     * @return float
     */
    public function getBussinessWithdrawRate(): float 
    {
        return $this->bussinessWithdrawRate;
    }

    /**
     * Set default private withdraw rating
     * 
     * @param float privateWithdrawRate
     * @return self
     */
    public function setPrivateWithdrawRate(float $privateWithdrawRate): self 
    {
        $this->privateWithdrawRate = $privateWithdrawRate;

        return $this;
    }

    /**
     * Get default private withdraw rating
     *      
     * @return float
     */
    public function getPrivateWithdrawRate(): float 
    {
        return $this->privateWithdrawRate;
    }

    /**
     * Set maximumn allowed times of free withdrawal
     * 
     * @param int privateWithdrawMaxTimes
     * @return self
     */
    public function setPrivateWithdrawMaxTimes(int $privateWithdrawMaxTimes): self 
    {
        $this->privateWithdrawMaxTimes = $privateWithdrawMaxTimes;

        return $this;
    }

    /**
     * Get maximumn allowed times of free withdrawal
     *      
     * @return int
     */
    public function getPrivateWithdrawMaxTimes(): int 
    {
        return $this->privateWithdrawMaxTimes;
    }

    /**
     * Set maximum limit of allowed free commission
     *      
     * @param int privateWithdrawMaxLimit
     * @return self
     */
    public function setPrivateWithdrawMaxLimit(int $privateWithdrawMaxLimit): self 
    {        
        $this->privateWithdrawMaxLimit =$privateWithdrawMaxLimit;

        return $this;
    }

    /**
     * Get maximum limit of allowed free commission
     *      
     * @return int
     */
    public function getPrivateWithdrawMaxLimit(): int 
    {
        return $this->privateWithdrawMaxLimit;
    }

    /**
     * Set currency information
     *
     * @param array $currency
     * @return self
     */
    public function setCurrency(array $currency): self 
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency convertion rating information
     *      
     * @return array
     */
    public function getCurrency(): array 
    {
        return $this->currency;
    }
}