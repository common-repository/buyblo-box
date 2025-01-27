<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 14:43
 */

namespace Nokaut\ApiKitBB\Repository;


use Nokaut\ApiKitBB\ClientApi\ClientApiInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\OfferFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\OffersFetch;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\Filter\Single;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\OfferQuery;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\OffersQuery;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\Sort;
use Nokaut\ApiKitBB\Collection\Offers;
use Nokaut\ApiKitBB\Converter\OfferConverter;
use Nokaut\ApiKitBB\Converter\OffersConverter;
use Nokaut\ApiKitBB\Entity\Offer;

class OffersRepository extends RepositoryAbstract
{

    public static $fieldsAll = array(
        'id', 'join_id', 'pattern_id', 'shop_id', 'shop_product_id', 'availability', 'category', 'description_html', 'title', 'price',
        'producer', 'promo', 'url', 'warranty', 'category_id', 'photo_id', 'photo_ids', 'cpc_value', 'expires_at', 'blocked_at',
        'click_value', 'visible', 'properties', 'description', 'click_url', 'shop.id', 'shop.name', 'shop.opineo_rating',
        'shop.url_logo', 'shop.high_quality', '_metadata'
    );

    public static $fieldsForProductPage = array(
        'id', 'join_id', 'pattern_id', 'title', 'price', 'availability', 'url', 'click_url', 'click_value', 'photo_id',
        'category_id', 'category_cpc', 'max_cpc', 'valid_cpa', 'weight', 'description', 'warranty', 'shop', 'shop_product_id',
        'shop_id', 'shop', 'shop.id', 'shop.url_logo', 'shop.name', 'shop.high_quality', 'shop.opineo_rating', '_metadata'
    );

    /**
     * @param $productId
     * @param array $fields
     * @param Sort $sort
     * @param int $limit
     * @return Offers
     * @throws \Exception
     */
    public function fetchOffersByProductId($productId, array $fields, Sort $sort = null, $limit = 200)
    {
        $query = $this->prepareQueryForFetchOffersByProductId($productId, $fields, $sort, $limit);
        $fetch = new OffersFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $id
     * @param array $fields
     * @return Offer
     */
    public function fetchOfferById($id, array $fields)
    {
        $query = $this->prepareQueryForFetchOfferById($id, $fields);
        $fetch = new OfferFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $shopId
     * @param array $fields
     * @param int $limit
     * @param Sort $sort
     * @return Offers
     */
    public function fetchOffersByShopId($shopId, array $fields, $limit = 20, Sort $sort = null)
    {
        $query = $this->prepareQueryForFetchOffersByShopId($shopId, $fields, $limit, $sort);
        $fetch = new OffersFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param OffersQuery $query
     * @return Offers
     */
    public function fetchOffersByQuery(OffersQuery $query)
    {
        $fetch = new OffersFetch($query, $this->cache);
        $this->clientApi->send($fetch);

        return $fetch->getResult();
    }

    /**
     * @param $productId
     * @param array $fields
     * @param Sort $sort
     * @param int $limit
     * @return OffersQuery
     */
    protected function prepareQueryForFetchOffersByProductId($productId, array $fields, Sort $sort = null, $limit = 200)
    {
        $query = new OffersQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setProductId($productId);

        if ($sort) {
            $query->setOrder($sort->getField(), $sort->getOrder());
        }
        if ($limit) {
            $query->setLimit($limit);
        }
        return $query;
    }

    /**
     * @param $id
     * @param array $fields
     * @return OfferQuery
     */
    protected function prepareQueryForFetchOfferById($id, array $fields)
    {
        $query = new OfferQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->setId($id);

        return $query;
    }

    /**
     * @param $shopId
     * @param array $fields
     * @param int $limit
     * @param Sort $sort
     * @return OffersQuery
     */
    protected function prepareQueryForFetchOffersByShopId($shopId, array $fields, $limit, Sort $sort = null)
    {
        $query = new OffersQuery($this->apiBaseUrl);
        $query->setFields($fields);
        $query->addFilter(new Single('shop_id', $shopId));
        $query->setLimit($limit);
        if ($sort) {
            $query->setOrder($sort->getField(), $sort->getOrder());
        }

        return $query;
    }
} 