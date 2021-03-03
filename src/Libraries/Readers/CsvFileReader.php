<?php

declare(strict_types=1);

namespace App\Libraries\Readers;

final class CsvFileReader implements ReaderInterface
{
    /**
     * Constructor
     * 
     * @param string file path
     * @param int $length
     * @param string $delimiter
     */
    public function __construct(
        private string $file,
        private int $length = 4096,
        private string $delimiter = ','
    ){}

    /**
     * Read the CSV file
     * 
     * @return Generator
     */
    public function read(): \Generator
    {
        $result = [];
        $handle = fopen($this->file, "r");

        if ($handle !== false) {
            while (($row = fgetcsv($handle, $this->length, $this->delimiter)) !== false) {
                if (is_array($row) && count($row) > 0) {
                    yield $row;                   
                }
            }
        }

        return $result;
    }
}