<?php

declare(strict_types=1);

namespace App\Tests\Libraries\Formatters;

use PHPUnit\Framework\TestCase;
use App\Libraries\Formatters\RoundedUpFormatter;

final class RoundedUpFormatterTest extends TestCase
{
    /**
     * Format the value
     */
    public function testFormat()
    {
        $formatter = new RoundedUpFormatter();

        $result = $formatter->format(0.023);
        $this->assertEquals(0.03, $result);

        $result = $formatter->format(60.591);
        $this->assertEquals(60.60, $result);
           
    }    
}
