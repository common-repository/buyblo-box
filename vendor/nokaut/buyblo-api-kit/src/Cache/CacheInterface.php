<?php

namespace Nokaut\BuybloApiKit\Cache;


interface CacheInterface
{
    public function get($keyName, $lifetime = null);

    public function save($keyName = null, $content = null, $lifetime = null);

    public function delete($keyName);

    public function getPrefixKeyName();
}