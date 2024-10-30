<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Query;


class StatusQuery extends QueryAbstract
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
    public function createRequestPath()
    {
        $query = $this->baseUrl . 'status?'
            . $this->createFieldsPart();

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
}