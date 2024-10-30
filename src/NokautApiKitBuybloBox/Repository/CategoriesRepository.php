<?php

namespace NokautApiKitBuybloBox\Repository;


use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\CategoriesFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\ApiKitBB\Collection\Categories;
use Nokaut\ApiKitBB\Collection\Sort\CategoriesSort;

class CategoriesRepository extends \Nokaut\ApiKitBB\Repository\CategoriesRepository
{
    public static $fieldsForSelect = array(
        'id',
        'title',
        'url'
    );

    public function fetchMenuCategories()
    {
        $query = $this->prepareQueryForFetchMenuCategories();
        $fetch = new CategoriesFetch($query, $this->cache);
        $this->clientApi->send($fetch);
        /** @var Categories $categories */
        $categories = $fetch->getResult();
        CategoriesSort::sortByTitle($categories);
        return $categories;
    }

    /**
     * @return CategoriesQuery
     */
    protected function prepareQueryForFetchMenuCategories()
    {
        $query = new CategoriesQuery($this->apiBaseUrl);
        $query->setFields(array('id', 'title', 'url'));
        $query->setParentId(0);
        $query->setDepth(1);
        return $query;
    }
}