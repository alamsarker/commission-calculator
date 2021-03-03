<?php

declare(strict_types=1);

namespace App\Libraries\Cache;

interface CacheInterface
{
    /**
     * Set the value for the cache
     * 
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value);

    /**
     * Get the cached value
     * 
     * @param string $key
     * @param mixed $default
     */
    public function get(string $key, $default = '');
}