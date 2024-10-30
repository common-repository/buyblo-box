<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\ClientApi\ClientApiInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\UsersFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Config;

class UsersAsyncRepository extends UsersRepository implements AsyncRepositoryInterface
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
     * @return UsersFetch
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getUsersQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getUsersFetch($query);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param string $slug
     * @param array $fields
     * @return UsersFetch
     */
    public function fetchOneBySlug($slug, array $fields)
    {
        $fetch = $this->prepareFetchOneBySlug($slug, $fields);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param int $phrase
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return UsersFetch
     */
    public function search($phrase, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('search', $phrase)
        );

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }
}