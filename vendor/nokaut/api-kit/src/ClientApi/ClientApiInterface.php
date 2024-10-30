<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.07.2014
 * Time: 08:52
 */

namespace Nokaut\ApiKitBB\ClientApi;


use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\Fetches;

interface ClientApiInterface {

    /**
     * @param Fetch $fetch
     */
    public function send(Fetch $fetch);

    /**
     * @param Fetches $fetches
     */
    public function sendMulti(Fetches $fetches);

}