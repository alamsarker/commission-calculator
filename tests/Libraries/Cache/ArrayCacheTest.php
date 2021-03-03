<?php

declare(strict_types=1);

namespace App\Tests\Libraries\Cache;

use PHPUnit\Framework\TestCase;
use App\Libraries\Cache\ArrayCache;

final class ArrayCacheTest extends TestCase
{
    public function testSetGet()
    {
        $cache = new ArrayCache();

        $result = $cache->get('defaultKey', 'default');
        $this->assertEquals('default', $result);

        $cache->set('key', 100);
        $result = $cache->get('key');
                
        $this->assertEquals(100, $result);      
    }    
}
