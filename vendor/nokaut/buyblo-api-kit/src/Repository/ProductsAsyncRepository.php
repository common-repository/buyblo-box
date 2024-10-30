<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\ClientApi\ClientApiInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\ProductsFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Config;
use Nokaut\BuybloApiKit\Entity\Product;

class ProductsAsyncRepository extends ProductsRepository implements AsyncRepositoryInterface
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
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return ProductsFetch
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getProductsQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getProductsFetch($query);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param string $categoryUrl
     * @param array $fields
     * @param int $limit
     * @param int $offset
     * @param Sort $sort
     * @param string|null $contextUserId
     * @return ProductsFetch
     */
    public function fetchByCategoryUrl($categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $fetch = $this->prepareFetchByCategoryUrl($categoryUrl, $fields, $limit, $offset, $sort, $contextUserId);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }
}