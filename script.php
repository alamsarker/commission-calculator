<?php

require_once 'vendor/autoload.php';

use App\Libraries\{
    Readers\CsvFileReader,
    Cache\ArrayCache,
    CurrencyConverter\CurrencyConverter,
    Commission\CommissionManager,
    Commission\Config,
    Formatters\RoundedUpFormatter,
};

$config = new Config();
$manager = new CommissionManager(
    new CurrencyConverter($config->getCurrency()),
    $config,
    new ArrayCache(),
    new RoundedUpFormatter()
);

$results = $manager
    ->setReader(new CsvFileReader($argv[1]))
    ->calculate();

foreach($results as $value) {
    echo $value . PHP_EOL;
}