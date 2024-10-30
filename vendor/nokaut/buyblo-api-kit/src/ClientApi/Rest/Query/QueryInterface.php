<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Query;


interface QueryInterface
{
    const OPERATION_GTE = 'gte';
    const OPERATION_LTE = 'lte';

    /**
     * @return string
     */
    public function createRequestPath();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return string
     */
    public function getBody();
}