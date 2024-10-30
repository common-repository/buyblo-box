<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\ClientApi\ClientApiInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Config;

class PostsAsyncRepository extends PostsRepository implements AsyncRepositoryInterface
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
     * @param string|null $contextUserId
     * @return \Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\PostsFetch
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $query = $this->getPostsQuery($fields, $filters, $limit, $offset, $sort);
        $query->setContextUserId($contextUserId);
        $fetch = $this->getPostsFetch($query);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param string $postDate
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @return \Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\PostsFetch
     */
    public function fetchLteDatePosts($postDate, array $fields, $limit = null, $offset = null)
    {
        $fetch = $this->prepareFetchLteDatePosts($postDate, $fields, $limit, $offset);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param string $categoryUrl
     * @param array $fields
     * @param int|null $limit
     * @param int|null $offset
     * @param Sort|null $sort
     * @param string|null $contextUserId
     * @return \Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\PostsFetch
     */
    public function fetchByCategoryUrl($categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $fetch = $this->prepareFetchByCategoryUrl($categoryUrl, $fields, $limit, $offset, $sort, $contextUserId);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param string $userId
     * @param array $fields
     * @param int $limit
     * @param int $offset
     * @param Sort $sort
     * @return \Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\PostsFetch
     */
    public function fetchDraftsByUserId($userId, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('user_id', $userId),
            new Single('visibility', 'false'),
        );
        $query = $this->getPostsQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getPostsFetch($query);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param string $userId
     * @param array $fields
     * @param int $limit
     * @param int $offset
     * @param Sort $sort
     * @param string|null $contextUserId
     * @return \Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\PostsFetch
     */
    public function fetchByUserId($userId, array $fields, $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $filters = array(
            new Single('user_id', $userId)
        );
        $query = $this->getPostsQuery($fields, $filters, $limit, $offset, $sort);
        $query->setContextUserId($contextUserId);
        $fetch = $this->getPostsFetch($query);
        $this->asyncRepo->addFetch($fetch);
        return $fetch;
    }

    /**
     * @param $phrase
     * @param null $categoryUrl
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return \Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\PostsFetch
     */
    public function search($phrase, $categoryUrl = null, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('search', $phrase)
        );

        if ($categoryUrl) {
            $filters[] = new Single('category_url', $categoryUrl);
        }

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }
}