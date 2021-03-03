<?php

declare(strict_types=1);

namespace App\Libraries\Commission\Rules;

use App\Libraries\Commission\Operation;

final class PrivateWithdrawRule extends AbstractRule
{
    /**
     * Withdraw Commission will be calculated for private client
     * 
     * @param Operation $operation
     * @return string
     */
    public function getCommission(Operation $operation): string
    {
        $commission = 0;
        $maxLimit = $this->config->getPrivateWithdrawMaxLimit();        
        $amount = $operation->getAmount();

        if (!$this->isEuro($operation)) {
            $amount = $this->currencyConverter->convert($operation->getCurrency(), 'EUR', $amount);
        }

        $counter = $this->cache->get($this->getKey($operation, 'counter'), 0);        
        $maxCommissined = $this->cache->get($this->getKey($operation, 'maxCommissined'), 0);    
        
        $counter++;
        $rate = $this->config->getPrivateWithdrawRate();
        if( $counter <= $this->config->getPrivateWithdrawMaxTimes() ) {
            $remaingCommissionable = 0;
            if ($maxCommissined < $maxLimit) {
                if ($amount >= $maxLimit) {                   
                    $remaingCommissionable = $maxLimit - $maxCommissined;
                    if ($remaingCommissionable <= $amount) {
                        $amount -= $remaingCommissionable;
                    }
                    $maxCommissined += $remaingCommissionable;                    
                } else {
                    $maxCommissined += $amount;
                    $rate = 0;
                }
            }                   
        }

        $this->cache->set($this->getKey($operation, 'counter'), $counter);
        $this->cache->set($this->getKey($operation, 'maxCommissined'), $maxCommissined);
       
        if ($amount > 0 && $rate > 0) {
            $commission = ($amount * $rate) / 100;
        }      

        if (!$this->isEuro($operation)) {
            $commission = $this->currencyConverter->revert('EUR', $operation->getCurrency(), $commission);
        }

        return $this->formatter->format($commission);         
    }    
}