<?php

namespace Nokaut\BuybloApiKit\Cache;


class NullCache extends AbstractCache
{
    public function get($keyName, $lifetime = null)
    {
        return null;
    }

    public function save($keyName = null, $content = null, $lifetime = null)
    {
    }

    public function delete($keyName)
    {
    }
} 