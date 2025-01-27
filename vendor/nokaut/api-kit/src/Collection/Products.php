<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.06.2014
 * Time: 13:36
 */

namespace Nokaut\ApiKitBB\Collection;


use Nokaut\ApiKitBB\Entity\Metadata;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\CategoryFacet;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\PhraseFacet;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\PriceFacet;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\ProducerFacet;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\PropertyFacet;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\ShopFacet;
use Nokaut\ApiKitBB\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKitBB\Entity\Product;

class Products extends CollectionAbstract
{

    /**
     * @var ProductsMetadata
     */
    protected $metadata;
    /**
     * @var CategoryFacet[]
     */
    protected $categories = array();
    /**
     * @var ShopFacet[]
     */
    protected $shops = array();
    /**
     * @var ProducerFacet[]
     */
    protected $producers = array();
    /**
     * @var PriceFacet[]
     */
    protected $prices = array();
    /**
     * @var PropertyFacet[]
     */
    protected $properties = array();
    /**
     * @var PhraseFacet
     */
    protected $phrase;

    /**
     * @param ProductsMetadata $metadata
     */
    public function setMetadata(ProductsMetadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return ProductsMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param CategoryFacet[] $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return CategoryFacet[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param ShopFacet[] $shop
     */
    public function setShops($shop)
    {
        $this->shops = $shop;
    }

    /**
     * @return ShopFacet[]
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * @param ProducerFacet[] $producers
     */
    public function setProducers($producers)
    {
        $this->producers = $producers;
    }

    /**
     * @return ProducerFacet[]
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * @param PriceFacet[] $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }

    /**
     * @return PriceFacet[]
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param PropertyFacet[] $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return PropertyFacet[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param PhraseFacet $phrase
     */
    public function setPhrase(PhraseFacet $phrase)
    {
        $this->phrase = $phrase;
    }

    /**
     * @return PhraseFacet
     */
    public function getPhrase()
    {
        return $this->phrase;
    }

    /**
     * Remove entity from collection
     * @param $id
     */
    public function removeById($id)
    {
        foreach ($this->entities as $index => $product) {
            /** @var Product $product */
            if ($product->getId() == $id) {
                unset($this->entities[$index]);
            }
        }
    }

    public function __clone()
    {
        parent::__clone();

        if ($this->metadata) {
            $this->metadata = clone $this->metadata;
        }

        if ($this->phrase) {
            $this->phrase = clone $this->phrase;
        }

        $this->categories = array_map(
            function ($category) {
                return clone $category;
            },
            $this->categories
        );

        $this->shops = array_map(
            function ($shop) {
                return clone $shop;
            },
            $this->shops
        );

        $this->producers = array_map(
            function ($producer) {
                return clone $producer;
            },
            $this->producers
        );

        $this->prices = array_map(
            function ($price) {
                return clone $price;
            },
            $this->prices
        );

        $this->properties = array_map(
            function ($property) {
                return clone $property;
            },
            $this->properties
        );
    }
}