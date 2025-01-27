<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.06.2014
 * Time: 10:02
 */

namespace Nokaut\ApiKitBB\Repository;


use Nokaut\ApiKitBB\Cache\NullCache;
use Nokaut\ApiKitBB\ClientApi\ClientApiInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\ProductFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\ProductRateCreateFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\ProductRatesFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\ProductRateUpdateFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\ProductsFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductRateQuery;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductRatesQuery;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\Sort;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\Filter;
use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Config;
use Nokaut\ApiKitBB\Converter\ProductsWithBestOfferConverter;
use Nokaut\ApiKitBB\Entity\Product;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductQuery;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKitBB\Converter\ProductConverter;
use Nokaut\ApiKitBB\Converter\ProductsConverter;
use Nokaut\ApiKitBB\Entity\Product\Rating;
use Nokaut\ApiKitBB\Entity\Product\Rating\Rate;
use Nokaut\ApiKitBB\Entity\ProductWithBestOffer;

class ProductsRepository extends RepositoryAbstract
{

    public static $fieldsForProductBox = array(
        'id', 'url', 'product_id', 'title', 'prices', 'offer_count', 'shop_count', 'category_id', 'offer_id',
        'url_original', 'offer_shop_id', 'shop_name', 'shop_url', 'top_category_id', 'top_position', 'photo_id',
        'click_url', 'click_value', 'shop', 'shop.url_logo', 'shop.name'
    );

    public static $fieldsWithBestOfferForProductBox = array(
        'id', 'url', 'product_id', 'title', 'prices', 'offer_count', 'shop_count', 'category_id', 'offer_id',
        'url_original', 'offer_shop_id', 'shop_name', 'shop_url', 'top_category_id', 'top_position', 'photo_id',
        'offer_with_minimum_price,offer_with_minimum_price.click_url', 'offer_with_minimum_price.price',
        'offer_with_minimum_price.id', 'producer_name'
    );

    public static $fieldsForProductPage = array(
        'id', 'url', 'category_id', 'description_html', 'id', 'prices',
        'is_with_photo', 'photo_id', 'producer_name', 'product_type_id', 'source', 'source_id', 'title', 'title_normalized',
        'properties', 'photo_ids', 'block_adsense', 'movie', 'rating'
    );

    public static $fieldsForList = array(
        'id', 'product_id', 'title', 'prices', 'offer_count', 'url', 'shop', 'shop.url_logo', 'shop_count', 'category_id',
        'offer_id', 'click_url', 'click_value', 'url_original', 'producer_name', 'offer_shop_id', 'shop.name', 'shop_url',
        'shop_id', 'top_category_id', 'top_position', 'photo_id', 'description_html', 'properties', '_metadata.url',
        '_metadata.block_adsense', 'offer', 'block_adsense', '_metadata.urls', '_metadata.paging', '_metadata.sorts',
        '_metadata.canonical', '_phrase.value', '_phrase.url_out', '_phrase.url_category_template', '_phrase.url_in_template'
    );

    public static $fieldsForSimilarProductsInProductPage = array(
        'id', 'url', 'title', 'prices', 'photo_id', 'description_short', 'properties'
    );


    /**
     * @param int $limit
     * @param $fields
     * @return Products
     */
    public function fetchProducts($limit, array $fields)
    {
        $query = $this->prepareQueryForFetchProducts($limit, $fields);
        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param string $producerName
     * @param int $limit
     * @param array $fields
     * @return Products
     */
    public function fetchProductsByProducerName($producerName, $limit, array $fields)
    {
        $query = $this->prepareQueryForFetchProductsByProducerName($producerName, $limit, $fields);

        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param array $categoryIds
     * @param int $limit
     * @param array $fields
     * @param Sort $sort - optional
     * @return Products
     */
    public function fetchProductsByCategory(array $categoryIds, $limit, array $fields, Sort $sort = null)
    {
        $query = $this->prepareQueryForFetchProductsByCategory($categoryIds, $limit, $fields, $sort);

        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @deprecated
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return Products
     */
    public function fetchSimilarProductsWithHigherPrice(Product $product, $limit, array $fields)
    {
        $query = $this->prepareQueryForFetchSimilarProductsWithHigherPrice($product, $limit, $fields);

        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @deprecated
     * @param Product $product
     * @param int $limit
     * @param array $fields
     * @return Products
     */
    public function fetchSimilarProductsWithLowerPrice(Product $product, $limit, array $fields)
    {
        $query = $this->prepareQueryForFetchSimilarProductsWithLowerPrice($product, $limit, $fields);

        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param ProductsQuery $query
     * @return Products
     */
    public function fetchProductsByQuery(ProductsQuery $query)
    {
        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param ProductsQuery $query
     * @return Products - return collection of ProductsWithBestOffer
     */
    public function fetchProductsWithBestOfferByQuery(ProductsQuery $query)
    {
        $fetch = new Fetch($query, new ProductsWithBestOfferConverter(), $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param string $id
     * @param array $fields
     * @return Product
     */
    public function fetchProductById($id, array $fields)
    {
        $query = $this->prepareQueryForFetchProductById($id, $fields);
        $fetch = new ProductFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $url
     * @param array $fields
     * @param int $limit
     * @return Products
     */
    public function fetchProductsByUrl($url, array $fields, $limit = 20)
    {
        $query = $this->prepareQueryForFetchProductsByUrl($url, $fields, $limit);
        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $url
     * @param array $fields
     * @param int $limit
     * @param int $quality
     * @return Products
     */
    public function fetchProductsByUrlWithQuality($url, array $fields, $limit = 20, $quality = 60)
    {
        $query = $this->prepareQueryForFetchProductsByUrlWithQuality($url, $fields, $limit, $quality);
        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $url
     * @param array $fields
     * @param int $limit
     * @return Products - return collection of ProductsWithBestOffer
     */
    public function fetchProductsWithBestOfferByUrl($url, array $fields, $limit = 20)
    {
        $query = $this->prepareQueryForFetchProductsByUrl($url, $fields, $limit);
        $fetch = new Fetch($query, new ProductsWithBestOfferConverter(), $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param string $url
     * @param array $fields
     * @return Product
     */
    public function fetchProductByUrl($url, array $fields)
    {
        $query = $this->prepareQueryForFetchProductByUrl($url, $fields);
        $fetch = new ProductFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param string $phrase
     * @return int
     */
    public function fetchCountProductsByPhrase($phrase)
    {
        $query = $this->prepareQueryForFetchCountProductsByPhrase($phrase);

        $fetch = new ProductsFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        /** @var Products $products */
        $products = $fetch->getResult();

        if ($products->getMetadata()) {
            return $products->getMetadata()->getTotal();
        } else {
            return 0;
        }
    }

    /**
     * @param $productId
     * @return Rating
     * @throws \Exception
     */
    public function fetchProductRating($productId)
    {
        $query = new ProductRatesQuery($this->apiBaseUrl);
        $query->setProductId($productId);

        $fetch = new ProductRatesFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        /** @var Rating $rating */
        $rating = $fetch->getResult();

        return $rating;
    }

    /**
     * @param $productId
     * @param Rate $rate
     * @return Rating
     */
    public function createProductRate($productId, Rate $rate)
    {
        $query = new ProductRatesQuery($this->apiBaseUrl);
        $query->setProductId($productId);
        $query->setMethod('POST');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $query->setBody($this->prepareRateCreateOrModifyQueryBody($rate));

        $fetch = new ProductRateCreateFetch($query, new NullCache());
        $this->clientApi->send($fetch);

        /** @var Rating $rating */
        $rating = $fetch->getResult();

        return $rating;
    }

    /**
     * @param $productId
     * @param Rate $rate
     * @return Rating
     */
    public function updateProductRate($productId, Rate $rate)
    {
        $query = new ProductRateQuery($this->apiBaseUrl);
        $query->setProductId($productId);
        $query->setRateId($rate->getId());
        $query->setMethod('PATCH');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $query->setBody($this->prepareRateCreateOrModifyQueryBody($rate));

        $fetch = new ProductRateUpdateFetch($query, new NullCache());
        $this->clientApi->send($fetch);

        /** @var Rating $rating */
        $rating = $fetch->getResult();

        return $rating;
    }

    /**
     * @param Rate $rate
     * @return string
     */
    protected function prepareRateCreateOrModifyQueryBody(Rate $rate)
    {
        $body = array();
        if ($rate->getRate() !== null) {
            $body['rate'] = (int)$rate->getRate();
        }
        if ($rate->getComment()) {
            $body['comment'] = $rate->getComment();
        }
        if ($rate->getUser()) {
            $body['user'] = $rate->getUser();
        }
        $body['ip_address'] = $rate->getIpAddress();

        return json_encode($body);
    }

    /**
     * @param $limit
     * @param array $fields
     * @return ProductsQuery
     */
    protected function prepareQueryForFetchProducts($limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setLimit($limit);
        $query->setFields($fields);
        return $query;
    }

    /**
     * @param $producerName
     * @param $limit
     * @param array $fields
     * @return ProductsQuery
     */
    protected function prepareQueryForFetchProductsByProducerName($producerName, $limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setProducerName($producerName);
        $query->setLimit($limit);
        $query->setFields($fields);
        return $query;
    }

    /**
     * @param array $categoryIds
     * @param $limit
     * @param array $fields
     * @param Sort $sort
     * @return ProductsQuery
     */
    protected function prepareQueryForFetchProductsByCategory(array $categoryIds, $limit, array $fields, Sort $sort = null)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setCategoryIds($categoryIds);
        $query->setLimit($limit);
        $query->setFields($fields);
        if ($sort) {
            $query->setOrder($sort->getField(), $sort->getOrder());
            return $query;
        }
        return $query;
    }

    /**
     * @deprecated
     * @param Product $product
     * @param $limit
     * @param array $fields
     * @return ProductsQuery
     */
    protected function prepareQueryForFetchSimilarProductsWithHigherPrice(Product $product, $limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setCategoryIds(array($product->getCategoryId()));
        $query->setFilterPriceMinFrom($product->getPrices()->getMin());
        $query->setLimit($limit);
        $query->setFields($fields);
        $query->setOrder('price_min', 'desc');
        return $query;
    }

    /**
     * @deprecated
     * @param Product $product
     * @param $limit
     * @param array $fields
     * @return ProductsQuery
     */
    protected function prepareQueryForFetchSimilarProductsWithLowerPrice(Product $product, $limit, array $fields)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setCategoryIds(array($product->getCategoryId()));
        $query->setFilterPriceMinTo($product->getPrices()->getMin());
        $query->setLimit($limit);
        $query->setFields($fields);
        $query->setOrder('price_min', 'asc');
        return $query;
    }

    /**
     * @param $id
     * @param array $fields
     * @return ProductQuery
     */
    protected function prepareQueryForFetchProductById($id, array $fields)
    {
        $query = new ProductQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setProductId($id);
        return $query;
    }

    /**
     * @param $url
     * @param array $fields
     * @param $limit
     * @return ProductsQuery
     */
    protected function prepareQueryForFetchProductsByUrl($url, array $fields, $limit)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->addFilter(new Filter\Single('url', $url));
        $query->setFields($fields);
        $query->addFacet('query');
        $query->addFacet('categories', 'relatives');
        $query->addFacet('producer_name');
        $query->addFacet('shops');
        $query->addFacet('properties');
        $query->addFacetRange('price_min', 4);
        $query->addFacetRange('properties', 4);
        $query->setLimit($limit);
        return $query;
    }

    /**
     * @param string $url
     * @param array $fields
     * @param int $limit
     * @param int $quality
     * @return ProductsQuery
     */
    protected function prepareQueryForFetchProductsByUrlWithQuality($url, array $fields, $limit, $quality)
    {
        $query = $this->prepareQueryForFetchProductsByUrl($url, $fields, $limit);
        $query->setQuality($quality);
        return $query;
    }

    /**
     * @param $url
     * @param array $fields
     * @return ProductQuery
     */
    protected function prepareQueryForFetchProductByUrl($url, array $fields)
    {
        $query = new ProductQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setUrl($url);
        return $query;
    }

    /**
     * @param $phrase
     * @return ProductsQuery
     */
    protected function prepareQueryForFetchCountProductsByPhrase($phrase)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setFields(array('id'));
        $query->setPhrase($phrase);
        return $query;
    }

}