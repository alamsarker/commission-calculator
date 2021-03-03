<?php

declare(strict_types=1);

namespace App\Libraries\Readers;

interface ReaderInterface
{
    /**
     * Read file
     * 
     * @return Generator
     */
    public function read(): \Generator;
}