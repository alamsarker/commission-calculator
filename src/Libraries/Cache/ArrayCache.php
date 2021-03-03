<?php

declare(strict_types=1);

namespace App\Libraries\Cache;

final class ArrayCache implements CacheInterface
{
    /**
     * @var static
     */
    private static $cache = [];

    /**
     * @param string $key The value will be saved in this key
     * @param mixed $value 
     */
    public function set(string $key, $value)
    {
        self::$cache[$key] = $value;
    }

    /**
     * @param string $key 
     * @param mixed $default The value if nothing found in this key
     */
    public function get(string $key, $default = '')
    {
        if (isset(self::$cache[$key])){
            return self::$cache[$key];
        }

        return $default;
    }
}