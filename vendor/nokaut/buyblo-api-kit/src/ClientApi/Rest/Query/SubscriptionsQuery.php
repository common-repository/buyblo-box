<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Query;


class SubscriptionsQuery extends QueryAbstract
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $subscriptionId;

    /**
     * @var array
     */
    protected $fields = array();

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var array
     */
    protected $sort = array();

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $subscriptionId
     */
    public function setSubscriptionId($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = (int)$offset;
    }

    /**
     * @param Sort $sort
     * @return array
     * @internal param string $field
     * @internal param string $order
     */
    public function addSort(Sort $sort)
    {
        $this->sort[$sort->getField()] = $sort->getOrder();
    }

    /**
     * @return string
     */
    public function createRequestPath()
    {
        if ($this->subscriptionId) {
            $query = $this->baseUrl . 'subscriptions/' . $this->subscriptionId;
        } elseif ($this->getMethod() == 'POST') {
            $query = $this->baseUrl . 'subscriptions';
        } else {
            $query = $this->baseUrl . 'subscriptions?'
                . $this->createFieldsPart()
                . ($this->getFilters() ? '&' . $this->createFilterPart() : '')
                . $this->createSortPart()
                . $this->createLimitPart()
                . $this->createOffsetPart();
        }

        return $query;
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function createFieldsPart()
    {
        if (empty($this->fields)) {
            throw new \InvalidArgumentException("Fields can't be empty");
        }
        return "fields=" . implode(',', $this->fields);
    }

    protected function createLimitPart()
    {
        if (!is_numeric($this->limit)) {
            return "";
        }
        return "&limit={$this->limit}";
    }

    protected function createOffsetPart()
    {
        if (empty($this->offset)) {
            return "";
        }
        return "&offset={$this->offset}";
    }

    protected function createSortPart()
    {
        $result = "";
        foreach ($this->sort as $field => $value) {
            $result .= "&sort[{$field}]={$value}";
        }
        return $result;
    }
}