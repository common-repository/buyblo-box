<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\ClientApi\Rest\Exception\FatalResponseException;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\CategoriesFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Collection\Categories;
use Nokaut\BuybloApiKit\Entity\Group;

class CategoriesRepository extends RepositoryAbstract
{
    /**
     * @var array
     */
    public static $fieldsAll = array(
        'id',
        'title',
        'url',
        'top_url',
//        'groups_count',
//        'subscription_id',
    );

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return CategoriesQuery
     */
    protected function getCategoriesQuery(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields($fields);

        if ($limit !== null) {
            $query->setLimit($limit);
        }

        if ($offset !== null) {
            $query->setOffset($offset);
        }

        if ($sort !== null) {
            $query->addSort($sort);
        }

        if ($filters) {
            foreach ($filters as $filter) {
                $query->addFilter($filter);
            }
        }

        return $query;
    }

    /**
     * @param CategoriesQuery $query
     * @return CategoriesFetch
     */
    protected function getCategoriesFetch(CategoriesQuery $query)
    {
        return new CategoriesFetch($query, $this->cache);
    }

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Categories
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getCategoriesQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getCategoriesFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $url
     * @param array $fields
     * @param stirng|null $contextUserId
     * @return Group
     */
    public function fetchOneByUrl($url, array $fields, $contextUserId = null)
    {
        $fetch = $this->prepareFetchOneByUrl($url, $fields, $contextUserId);
        $this->clientApi->send($fetch);
        return $this->fetchOne($fetch);
    }

    /**
     * @param string $url
     * @param array $fields
     * @param string|null $contextUserId
     * @return CategoriesFetch
     */
    protected function prepareFetchOneByUrl($url, array $fields, $contextUserId = null)
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->addFilter(new Single('url', $url));
        $query->setContextUserId($contextUserId);

        $fetch = new CategoriesFetch($query, $this->cache);
        return $fetch;
    }

    /**
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Categories
     */
    public function fetchCategoriesTopLeaves(array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $fetch = $this->prepareFetchCategoriesTopLeaves($fields, $limit, $offset, $sort);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param array $fields
     * @param $limit
     * @param $offset
     * @param Sort $sort
     * @return CategoriesFetch
     */
    protected function prepareFetchCategoriesTopLeaves(array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getCategoriesQuery($fields, array(), $limit, $offset, $sort);
        return $this->getCategoriesFetch($query);
    }

    /**
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Categories
     */
    public function fetchCategoriesTopRoots(array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $fetch = $this->prepareFetchCategoriesTopRoots($fields, $limit, $offset, $sort);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param array $fields
     * @param $limit
     * @param $offset
     * @param Sort $sort
     * @return CategoriesFetch
     */
    protected function prepareFetchCategoriesTopRoots(array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(new Single('depth', 1));
        $query = $this->getCategoriesQuery($fields, $filters, $limit, $offset, $sort);
        return $this->getCategoriesFetch($query);
    }

    /**
     * @param string $userId
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Categories
     */
    public function fetchUserCategoriesTopRoots($userId, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $fetch = $this->prepareFetchUserCategoriesTopRoots($userId, $fields, $limit, $offset, $sort);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $userId
     * @param array $fields
     * @param $limit
     * @param $offset
     * @param Sort $sort
     * @return CategoriesFetch
     */
    protected function prepareFetchUserCategoriesTopRoots($userId, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('depth', 1),
            new Single('user_id', $userId)
        );
        $query = $this->getCategoriesQuery($fields, $filters, $limit, $offset, $sort);
        return $this->getCategoriesFetch($query);
    }

    /**
     * @param string $categoryUrl
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Categories
     */
    public function fetchCategoryTopLeaves($categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $fetch = $this->prepareFetchCategoryTopLeaves($categoryUrl, $fields, $limit, $offset, $sort);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param $categoryUrl
     * @param array $fields
     * @param $limit
     * @param $offset
     * @param Sort $sort
     * @return CategoriesFetch
     */
    protected function prepareFetchCategoryTopLeaves($categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(new Single('top_url', $categoryUrl));
        $query = $this->getCategoriesQuery($fields, $filters, $limit, $offset, $sort);
        return $this->getCategoriesFetch($query);
    }

    /**
     * @param int $phrase
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Categories
     */
    public function search($phrase, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('search', $phrase)
        );

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }

    /**
     * @param array $ids
     * @param array $fields
     * @return Categories
     */
    public function fetchByIds(array $ids, array $fields)
    {
        $filters = array(
            new Single('id', implode(',', $ids))
        );

        return $this->fetchAll($fields, $filters, count($ids));
    }
}