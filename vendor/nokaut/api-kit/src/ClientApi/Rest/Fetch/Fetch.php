<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.07.2014
 * Time: 13:36
 */

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\QueryBuilderInterface;
use Nokaut\ApiKitBB\Collection\CollectionInterface;
use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\EntityAbstract;

class Fetch
{
    /**
     * @var QueryBuilderInterface
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
     * @param QueryBuilderInterface $query
     * @param ConverterInterface $converter
     * @param CacheInterface $cache
     */
    function __construct(QueryBuilderInterface $query, ConverterInterface $converter , CacheInterface $cache)
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
     * @param QueryBuilderInterface $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return QueryBuilderInterface
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
        if($result) {
            $this->result = $this->converter->convert($result);
        }else{
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