# Commission Calculator

Commission Calculator for deposit and withdrawal operation.

## Installation
Step 1: Prerequisites

    * Install docker
        * Ubuntu: https://docs.docker.com/engine/install/ubuntu/
        * Windows: https://docs.docker.com/docker-for-windows/install/
    * Install docker-compose
        * Ubuntu: https://docs.docker.com/compose/install/
        * Windows: Not necessary. Windows docker installer has docker-composer included.

    Run `docker -v` and `docker-compose -v` to make sure the installation.

Step 2: Install PHP and vendor packages

   * Run `make` from the root directory of the project. If it's not working, then try to use `sudo` as `sudo make start`
   * Run `make composer-install` to install vendor packages. 

Note: `make` command may not works in windows. In that case, its required to run: `docker-compose up`

All done?

* Start Container: `make` or `make start`
* See the output: `make script`
* Run unit test: `make phpunit`


## Usage

```
use App\Libraries\{
    Readers\CsvFileReader,
    Cache\ArrayCache,
    CurrencyConverter\CurrencyConverter,
    Commission\CommissionManager,
    Commission\Config,
    Formatters\RoundedUpFormatter,
};

$csvFilePath = 'input.csv';

$config = new Config();
$manager = new CommissionManager(
    new CurrencyConverter($config->getCurrency()),
    $config,
    new ArrayCache(),
    new RoundedUpFormatter()
);

$results = $manager
    ->setReader(new CsvFileReader($csvFilePath))
    ->calculate();
```


## Important Notes

* For the sake of simplicity, its been used `App\Libraries\Commission\Config` class for saving the commission and currency settings. In real life, its may be moved to yml or database.
* It has not been used the latest api rates by calling the api. Instead, used the static currency rates in config class.
* This solution has been tested with the provided CSV file only. A single output of the input `2016-02-19,5,private,withdraw,3000000,JPY` has not matched. Expected output is `8612` but `8611.42` is produced by this solution.
* Exceptions has not handled.


## Explanation of the confusing/complex code

The following few code block is confusing to understand. Lets discuss that part:-

The below block of code has been taken from `App\Libraries\Commission\Rules\PrivateWithdrawRule` class of `getCommission()` method.

```
1. $rate = $this->config->getPrivateWithdrawRate();
2. if( $counter <= $this->config->getPrivateWithdrawMaxTimes() ) {
3.    $remaingCommissionable = 0;
4.    if ($maxCommissined < $maxLimit) {
5.        if ($amount >= $maxLimit) {                   
6.            $remaingCommissionable = $maxLimit - $maxCommissined;
7.            if ($remaingCommissionable <= $amount) {
8.                $amount -= $remaingCommissionable;
9.            }
10.           $maxCommissined += $remaingCommissionable;                    
11.        } else {
12.            $maxCommissined += $amount;
13.            $rate = 0;
14.        }
15.    }                   
16. }
```
* line 1: The withdrawal commission of private client will be the default rate `0.3%`.
* line 2: Checking weekly free operation times that configured in setting.
* line 4-11: Calculate the max commission and the operation amount.
* line 12,13: Commission rating will be `0`if operation amount is within allowable free max amount that is `1000 EUR`

Another block of code has been taken from `App\Libraries\CurrencyConverter\CurrencyConverter` class.

Please look on the following two method.

```
public function convert(string $from, string $to, float $amount): float;
public function revert(string $from, string $to, float $amount): float;
```
`convert()` method is easy to use. But for use the `revert()` method, it should be same base when it was converted.


## Technology

* PHP 8.0.0 
* Docker
* Docker-compose
