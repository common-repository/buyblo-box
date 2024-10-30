<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Query;


class UsersQuery extends QueryAbstract
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var array
     */
    protected $fields = array();

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $contextUserId;

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
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param string $contextUserId
     */
    public function setContextUserId($contextUserId)
    {
        $this->contextUserId = $contextUserId;
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

        if ($this->userId) {
            $query = $this->baseUrl . 'users/' . $this->userId;
        } else {
            if ($this->getMethod() == 'POST') {
                $query = $this->baseUrl . 'users';
            } else {
                $query = $this->baseUrl . 'users?'
                    . $this->createFieldsPart()
                    . ($this->getFilters() ? '&' . $this->createFilterPart() : '')
                    . ($this->contextUserId ? '&' . $this->createContextUserIdPart() : '')
                    . $this->createSortPart()
                    . $this->createLimitPart()
                    . $this->createOffsetPart();
            }
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

    /**
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function createContextUserIdPart()
    {
        if (empty($this->contextUserId)) {
            return '';
        }
        return 'user_id=' . $this->contextUserId;
    }
}