<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\ProductsFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Collection\Products;

class ProductsRepository extends RepositoryAbstract
{
    /**
     * @var array
     */
    public static $fieldsAll = array(
        'id',
        'type',
        'posts_count',
//        'subscription_id',
        'metadata.total',
    );

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return ProductsQuery
     */
    protected function getProductsQuery(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
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
     * @param ProductsQuery $query
     * @return ProductsFetch
     */
    protected function getProductsFetch(ProductsQuery $query)
    {
        return new ProductsFetch($query, $this->cache);
    }

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Products
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getProductsQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getProductsFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $categoryUrl
     * @param array $fields
     * @param int $limit
     * @param int $offset
     * @param Sort $sort
     * @param string|null $contextUserId
     * @return Products
     */
    public function fetchByCategoryUrl($categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $fetch = $this->prepareFetchByCategoryUrl($categoryUrl, $fields, $limit, $offset, $sort, $contextUserId);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
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
    protected function prepareFetchByCategoryUrl($categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $query = $this->getProductsQuery($fields, array(new Single('category_url', $categoryUrl)), $limit, $offset, $sort);
        $query->setContextUserId($contextUserId);
        return $this->getProductsFetch($query);
    }

    /**
     * @param array $ids
     * @param array $fields
     * @return Products
     */
    public function fetchByIds(array $ids, array $fields)
    {
        $filters = array(
            new Single('id', implode(',', $ids))
        );

        return $this->fetchAll($fields, $filters, count($ids));
    }
}