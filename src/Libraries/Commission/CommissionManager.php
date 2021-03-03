<?php

declare(strict_types=1);

namespace App\Libraries\Commission;

use App\Libraries\{
    Readers\ReaderInterface,
    Cache\CacheInterface,
    CurrencyConverter\AbstractCurrencyConverter,
    Commission\Rules\AbstractRule,
    Formatters\FormatterInterface
};

final class CommissionManager
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
        private AbstractCurrencyConverter $currencyConverter,
        private Config $config,
        private CacheInterface $cache,
        private FormatterInterface $formatter
    ){}

    /**
     * Dynamically Rule class is generated
     * 
     * @param string $userType User's type, one of private or business
     * @param string $operationType Operation type, one of deposit or withdraw
     * @return AbstractRule
     */
    private function getCommissionRule(string $userType, string $operationType): AbstractRule
    {
        $ruleClass = sprintf(
            'App\\Libraries\\Commission\\Rules\\%s%sRule', 
            ucfirst($userType), 
            ucfirst($operationType)
        );

        if (!class_exists($ruleClass)) {
            $ruleClass = sprintf(
                'App\\Libraries\\Commission\\Rules\\%sRule',                 
                ucfirst($operationType)
            );
        }
        
        return new $ruleClass(
            $this->currencyConverter, 
            $this->config,
            $this->cache,
            $this->formatter
        );
    }

    /**
     * Set the file Reader
     * 
     * @param ReaderInterface $reader
     * @param self
     */
    public function setReader(ReaderInterface $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * Input is prepared with Operation class
     * 
     * @param array $input The input operation
     * @return Operation 
     */
    private function getOperation(array $input): Operation
    {
        return new Operation(
            new \DateTime($input[0]),
            (int)$input[1],
            $input[2], 
            $input[3], 
            (float)$input[4], 
            $input[5]
        );
    }
    
    /**
     * Calculate Commission for deposit and withdraw
     * 
     * @return array
     */
    public function calculate()
    {
        $result = [];
        $inputData = $this->reader->read();
        foreach($inputData as $input){
           $operation = $this->getOperation($input);                   
           
           $commissionRule = $this->getCommissionRule(
               $operation->getUserType(), 
               $operation->getOperationType()
            );    

           $result[] = $commissionRule->getCommission($operation);
        }

        return $result;
    }
}