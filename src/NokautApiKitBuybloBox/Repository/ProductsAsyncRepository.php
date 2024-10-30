<?php

namespace NokautApiKitBuybloBox\Repository;

use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\ProductsFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\Filter;

class ProductsAsyncRepository extends \Nokaut\ApiKitBB\Repository\ProductsAsyncRepository
{
    const CATEGORY_FACET_LEVEL_1 = 'top';
    const CATEGORY_FACET_RELATIVES = 'relatives';

    /**
     * @param $url
     * @param string $categoryFacet top, relative
     * @param int $quality
     * @return ProductsFetch
     */
    public function fetchProductsForCategoryFacetByUrl($url, $categoryFacet, $quality = 60)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setFields(array('_categories.url_in', '_phrase.value'));
        $query->addFilter(new Filter\Single('url', $url));
        $query->addFacet('query', 'false');
        $query->addFacet('categories', $categoryFacet);
        $query->setQuality($quality);
        $query->setLimit(0);

        $productsAsyncFetch = new ProductsFetch($query, $this->cache);
        $this->asyncRepo->addFetch($productsAsyncFetch);
        return $productsAsyncFetch;
    }
}