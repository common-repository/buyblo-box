<?php

namespace Nokaut\BuybloApiKit\Cache;


abstract class AbstractCache implements CacheInterface
{
    public function getPrefixKeyName()
    {
        return 'buyblo-api-raw-';
    }
}