<?php

declare(strict_types=1);

namespace App\Libraries\Commission;

class Operation {

    /**
     * Constructor
     * 
     * This class is used for making object of operation input
     */
    public function __construct(
        private \DateTime $transDate,
        private int $userId,
        private string $userType,
        private string $operationType,
        private float $amount,
        private string $currency,
    ){}

    public function setTransDate($transDate)
    {
        $this->transDate = $transDate;

        return $this;
    }

    public function getTransDate(): \DateTime
    {
        return $this->transDate;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserType(string $userType)
    {
        $this->userType = $userType;

        return $this;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function setOperationType(string $operationType)
    {
        $this->operationType = $operationType;

        return $this;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setCurrency(string $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }    
}