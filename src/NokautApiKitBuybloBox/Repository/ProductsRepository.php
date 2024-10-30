<?php

namespace NokautApiKitBuybloBox\Repository;

use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\ProductsFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\Filter\MultipleWithOperator;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\Filter\Single;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKitBB\Collection\Products;

class ProductsRepository extends \Nokaut\ApiKitBB\Repository\ProductsRepository
{
    public static $fieldsForProductBox = array(
        'id',
        'title',
        'url',
        'category_id'
    );

    /**
     * @param string $phrase
     * @param int $limit
     * @param array $fields
     * @return Products
     */
    public function fetchProductsByPhrase($phrase, $limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setLimit($limit);
        $query->setFields($fields);
        $query->setPhrase($phrase);

        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param array $ids
     * @param array $fields
     * @param bool $scopeAll
     * @return Products
     */
    public function fetchProductsByIds(array $ids, array $fields, $scopeAll = false)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setFields($fields, !$scopeAll);
        if ($scopeAll) {
            $query->addFilter(new Single('scope', 'all'));
        }
        $query->addFilter(new MultipleWithOperator('id', 'in', $ids));

        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }
}