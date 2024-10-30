<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter;

class Groups implements FilterInterface
{
    /**
     * @var array
     */
    protected $groups;

    /**
     * @param array $groups
     */
    public function __construct(array $groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return string
     */
    public function toHash()
    {
        return md5('groups');
    }

    public function __toString()
    {
        $filter = array();

        foreach ($this->groups as $index => $values) {
            foreach ($values as $value) {
                $filter[] = sprintf("groups[%s][]=%s", $index, $value, urlencode($value));
            }
        }

        return implode("&", $filter);
    }
}