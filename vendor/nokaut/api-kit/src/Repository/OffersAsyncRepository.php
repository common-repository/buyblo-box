<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:10
 */

namespace Nokaut\ApiKitBB\Repository;


use Nokaut\ApiKitBB\ClientApi\ClientApiInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\OfferFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\OffersFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\OffersQuery;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\Sort;
use Nokaut\ApiKitBB\Config;

class OffersAsyncRepository extends OffersRepository implements AsyncRepositoryInterface
{
    /**
     * @var AsyncRepository
     */
    protected $asyncRepo;

    /**
     * @param Config $config
     * @param ClientApiInterface $clientApi
     */
    public function __construct(Config $config, ClientApiInterface $clientApi)
    {
        parent::__construct($config, $clientApi);
        $this->asyncRepo = new AsyncRepository($clientApi);
    }

    public function clearAllFetches()
    {
        $this->asyncRepo->clearAllFetches();
    }

    public function fetchAllAsync()
    {
        $this->asyncRepo->fetchAllAsync();
    }

    /**
     * @param $productId
     * @param array $fields
     * @param Sort $sort
     * @param int $limit
     * @return OffersFetch
     */
    public function fetchOffersByProductId($productId, array $fields, Sort $sort = null, $limit = 200)
    {
        $offersAsyncFetch = new OffersFetch($this->prepareQueryForFetchOffersByProductId($productId, $fields, $sort, $limit), $this->cache);
        $this->asyncRepo->addFetch($offersAsyncFetch);
        return $offersAsyncFetch;
    }

    public function fetchOfferById($id, array $fields)
    {
        $offersAsyncFetch = new OfferFetch($this->prepareQueryForFetchOfferById($id, $fields), $this->cache);
        $this->asyncRepo->addFetch($offersAsyncFetch);
        return $offersAsyncFetch;
    }

    /**
     * @param OffersQuery $query
     * @return OffersFetch
     */
    public function fetchOffersByQuery(OffersQuery $query)
    {
        $offersAsyncFetch = new OffersFetch($query, $this->cache);
        $this->asyncRepo->addFetch($offersAsyncFetch);
        return $offersAsyncFetch;
    }

    /**
     * @param $shopId
     * @param array $fields
     * @param int $limit
     * @param Sort $sort
     * @return OffersFetch
     */
    public function fetchOffersByShopId($shopId, array $fields, $limit = 20, Sort $sort = null)
    {
        $offersAsyncFetch = new OffersFetch($this->prepareQueryForFetchOffersByShopId($shopId, $fields, $limit, $sort), $this->cache);
        $this->asyncRepo->addFetch($offersAsyncFetch);
        return $offersAsyncFetch;
    }
}