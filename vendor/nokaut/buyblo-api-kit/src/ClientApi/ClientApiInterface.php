<?php

namespace Nokaut\BuybloApiKit\ClientApi;


use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\Fetches;

interface ClientApiInterface
{
    /**
     * @param Fetch $fetch
     */
    public function send(Fetch $fetch);

    /**
     * @param Fetches $fetches
     */
    public function sendMulti(Fetches $fetches);
}