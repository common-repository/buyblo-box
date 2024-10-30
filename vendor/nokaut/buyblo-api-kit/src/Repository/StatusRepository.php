<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\StatusFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\StatusQuery;
use Nokaut\BuybloApiKit\Entity\Status;

class StatusRepository extends RepositoryAbstract
{
    /**
     * @var array
     */
    public static $fieldsAll = array(
        'access_token'
    );

    /**
     * @param $fields
     * @return Status
     */
    public function fetch($fields)
    {
        $query = new StatusQuery($this->apiBaseUrl);
        $query->setFields($fields);

        $fetch = new StatusFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }
}