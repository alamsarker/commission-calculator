<?php

declare(strict_types=1);

namespace App\Libraries\Commission\Rules;

use App\Libraries\Commission\Operation;

final class BusinessWithdrawRule extends AbstractRule
{
    /**
     * Withdraw Commission will be calculated for business client
     * 
     * @param Operation $operation
     * @return string
     */
    public function getCommission(Operation $operation): string
    {
        $commission = 0;
        $amount = $operation->getAmount();
        $rate = $this->config->getBussinessWithdrawRate();

        if ($amount > 0 && $rate > 0) {
            $commission = ($amount * $rate) / 100;
        }

        return $this->formatter->format($commission);
    }
}