<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 29.03.2014
 * Time: 20:55
 */

namespace Nokaut\ApiKitBB\ClientApi\Rest\Query;


interface QueryBuilderInterface
{

    const OPERATION_GTE = 'gte';
    const OPERATION_LTE = 'lte';

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