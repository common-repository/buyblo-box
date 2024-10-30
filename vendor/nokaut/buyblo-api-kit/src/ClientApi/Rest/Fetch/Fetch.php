<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\QueryInterface;
use Nokaut\BuybloApiKit\Collection\CollectionInterface;
use Nokaut\BuybloApiKit\Converter\ConverterInterface;
use Nokaut\BuybloApiKit\Entity\EntityAbstract;

class Fetch
{
    /**
     * @var QueryInterface
     */
    protected $query;
    /**
     * @var ConverterInterface
     */
    protected $converter;
    /**
     * @var CollectionInterface|EntityAbstract
     */
    protected $result;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * flag show if result was taken form cache/API
     * @var bool
     */
    protected $processed = false;

    /**
     * @var \Exception
     */
    protected $responseException;

    /**
     * @param QueryInterface $query
     * @param ConverterInterface $converter
     * @param CacheInterface $cache
     */
    function __construct(QueryInterface $query, ConverterInterface $converter, CacheInterface $cache)
    {
        $this->query = $query;
        $this->converter = $converter;
        $this->cache = $cache;
    }


    /**
     * @param ConverterInterface $converter
     */
    public function setConverter($converter)
    {
        $this->converter = $converter;
    }

    /**
     * @return ConverterInterface
     */
    public function getConverter()
    {
        return $this->converter;
    }

    /**
     * @param QueryInterface $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return QueryInterface
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param \stdClass $result - raw result from ClientApi
     */
    public function setResult($result)
    {
        if ($result) {
            $this->result = $this->converter->convert($result);
        } else {
            $this->result = null;
        }
    }

    /**
     * @param bool $throwException
     * @throws \Exception
     * @return CollectionInterface|EntityAbstract
     */
    public function getResult($throwException = false)
    {
        if ($this->result === null && $this->responseException !== null && $throwException) {
            throw $this->responseException;
        }
        return $this->result;
    }

    /**
     * @param CacheInterface $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @return string
     */
    public function prepareCacheKey()
    {
        return $this->cache->getPrefixKeyName() . md5($this->query->createRequestPath());
    }

    /**
     * @param boolean $processed
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;
    }

    /**
     * @return boolean
     */
    public function isProcessed()
    {
        return $this->processed;
    }

    /**
     * @param \Exception $responseException
     */
    public function setResponseException($responseException)
    {
        $this->responseException = $responseException;
    }

    /**
     * @return \Exception
     */
    public function getResponseException()
    {
        return $this->responseException;
    }

}