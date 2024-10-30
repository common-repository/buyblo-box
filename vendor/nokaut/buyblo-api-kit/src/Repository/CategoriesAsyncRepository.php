<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\ClientApi\ClientApiInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\CategoriesFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Config;

class CategoriesAsyncRepository extends CategoriesRepository implements AsyncRepositoryInterface
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
     * @return CategoriesFetch
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getCategoriesQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getCategoriesFetch($query);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param string $url
     * @param array $fields
     * @param string|null $contextUserId
     * @return CategoriesFetch
     */
    public function fetchOneByUrl($url, array $fields, $contextUserId = null)
    {
        $fetch = $this->prepareFetchOneByUrl($url, $fields, $contextUserId);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return CategoriesFetch
     */
    public function fetchCategoriesTopLeaves(array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $fetch = $this->prepareFetchCategoriesTopLeaves($fields, $limit, $offset, $sort);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return CategoriesFetch
     */
    public function fetchCategoriesTopRoots(array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $fetch = $this->prepareFetchCategoriesTopRoots($fields, $limit, $offset, $sort);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param string $userId
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return CategoriesFetch
     */
    public function fetchUserCategoriesTopRoots($userId, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $fetch = $this->prepareFetchUserCategoriesTopRoots($userId, $fields, $limit, $offset, $sort);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param string $categoryUrl
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return CategoriesFetch
     */
    public function fetchCategoryTopLeaves($categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $fetch = $this->prepareFetchCategoryTopLeaves($categoryUrl, $fields, $limit, $offset, $sort);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param int $phrase
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return CategoriesFetch
     */
    public function search($phrase, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('search', $phrase)
        );

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }
}