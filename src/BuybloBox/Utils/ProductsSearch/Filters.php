<?php

namespace BuybloBox\Utils\ProductsSearch;


use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Entity\Category;
use Nokaut\ApiKitBB\Ext\Data;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\PhraseFacet;

class Filters
{
    /**
     * @var PhraseFacet
     */
    private $phrase;

    /**
     * @var Data\Collection\Filters\Categories
     */
    private $filtersCategories;

    /**
     * @var Data\Collection\Filters\Categories
     */
    private $filtersSelectedCategories;

    /**
     * @var Data\Collection\Filters\Producers
     */
    private $filtersProducers;

    /**
     * @var Data\Collection\Filters\Producers
     */
    private $filtersSelectedProducers;

    /**
     * @var Data\Collection\Filters\Shops
     */
    private $filtersShops;

    /**
     * @var Data\Collection\Filters\Shops
     */
    private $filtersSelectedShops;

    /**
     * @var Data\Collection\Filters\PriceRanges
     */
    private $filtersPriceRanges;

    /**
     * @var Data\Collection\Filters\PriceRanges
     */
    private $filtersSelectedPriceRanges;

    /**
     * @var Data\Collection\Filters\PropertyAbstract[]
     */
    private $filtersProperties;

    /**
     * @var Data\Collection\Filters\PropertyAbstract[]
     */
    private $filtersSelectedProperties;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var Products
     */
    private $products;

    /**
     * @param Products $products
     * @param Category $category
     */
    public function __construct(Products $products, Category $category = null)
    {
        $this->setCategory($category);
        $this->setProducts($products);
        $this->init();
    }

    /**
     * @param \Nokaut\ApiKitBB\Collection\Products $products
     */
    private function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return \Nokaut\ApiKitBB\Collection\Products
     */
    private function getProducts()
    {
        return $this->products;
    }

    /**
     * @param \Nokaut\ApiKitBB\Entity\Category $category
     */
    private function setCategory(Category $category = null)
    {
        $this->category = $category;
    }

    /**
     * @return \Nokaut\ApiKitBB\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    private function init()
    {
        $products = $this->getProducts();

        // categories
        $filtersCategoriesConverter = new Data\Converter\Filters\CategoriesConverter();
        $this->filtersCategories = $filtersCategoriesConverter->convert($products, array(
            new Data\Converter\Filters\Callback\Categories\SetIsExcluded(),
            new Data\Converter\Filters\Callback\Categories\SortByName()
        ));

        $filtersSelectedCategoriesConverter = new Data\Converter\Filters\Selected\CategoriesConverter();
        $this->filtersSelectedCategories = $filtersSelectedCategoriesConverter->convert($products, array());

        // producers
        $filtersProducersConverter = new Data\Converter\Filters\ProducersConverter();
        $this->filtersProducers = $filtersProducersConverter->convert($products, array(
            new Data\Converter\Filters\Callback\Producers\SetIsActive(),
            new Data\Converter\Filters\Callback\Producers\SetIsExcluded(),
            new Data\Converter\Filters\Callback\Producers\SetIsPopular(),
            new Data\Converter\Filters\Callback\Producers\SortByName()
        ));

        $filtersSelectedProducersConverter = new Data\Converter\Filters\Selected\ProducersConverter();
        $this->filtersSelectedProducers = $filtersSelectedProducersConverter->convert($products, array());

        // shops
        $filtersShopsConverter = new Data\Converter\Filters\ShopsConverter();
        $this->filtersShops = $filtersShopsConverter->convert($products, array(
            new Data\Converter\Filters\Callback\Shops\SetIsActive(),
            new Data\Converter\Filters\Callback\Shops\SetIsExcluded(),
            new Data\Converter\Filters\Callback\Shops\SetIsPopular(),
            new Data\Converter\Filters\Callback\Shops\SortByName()
        ));

        $filtersSelectedShopsConverter = new Data\Converter\Filters\Selected\ShopsConverter();
        $this->filtersSelectedShops = $filtersSelectedShopsConverter->convert($products, array());

        // prices
        $filtersPriceRangesConverter = new Data\Converter\Filters\PriceRangesConverter();
        $this->filtersPriceRanges = $filtersPriceRangesConverter->convert($products, array());

        $filtersSelectedPriceRangesConverter = new Data\Converter\Filters\Selected\PriceRangesConverter();
        $this->filtersSelectedPriceRanges = $filtersSelectedPriceRangesConverter->convert($products, array());

        // properties
        $filtersPropertiesConverter = new Data\Converter\Filters\PropertiesConverter();
        $this->filtersProperties = $filtersPropertiesConverter->convert($products, array(
            new Data\Converter\Filters\Callback\Property\SetIsActive(),
            new Data\Converter\Filters\Callback\Property\SetIsExcluded(),
            new Data\Converter\Filters\Callback\Property\SortDefault()
        ));

        $filtersSelectedPropertiesConverter = new Data\Converter\Filters\Selected\PropertiesConverter();
        $this->filtersSelectedProperties = $filtersSelectedPropertiesConverter->convert($products, array());

        $this->initPhrase($products);
    }

    /**
     * @param Products $products
     */
    public function initPhrase(Products $products)
    {
        $phrase = $products->getPhrase();

        if (!($phrase instanceof PhraseFacet)) {
            $phrase = new PhraseFacet();
        }

        $this->phrase = $phrase;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Categories
     */
    public function getFiltersCategories()
    {
        return $this->filtersCategories;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PriceRanges
     */
    public function getFiltersPriceRanges()
    {
        return $this->filtersPriceRanges;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Producers
     */
    public function getFiltersProducers()
    {
        return $this->filtersProducers;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PropertyAbstract[]
     */
    public function getFiltersProperties()
    {
        return $this->filtersProperties;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Categories
     */
    public function getFiltersSelectedCategories()
    {
        return $this->filtersSelectedCategories;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PriceRanges
     */
    public function getFiltersSelectedPriceRanges()
    {
        return $this->filtersSelectedPriceRanges;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Entity\Filter\PriceRange|null
     */
    public function getFilterSelectedPriceRange()
    {
        return count($this->getFiltersSelectedPriceRanges()) ? $this->getFiltersSelectedPriceRanges()->getLast() : null;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Producers
     */
    public function getFiltersSelectedProducers()
    {
        return $this->filtersSelectedProducers;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PropertyAbstract[]
     */
    public function getFiltersSelectedProperties()
    {
        return $this->filtersSelectedProperties;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Shops
     */
    public function getFiltersSelectedShops()
    {
        return $this->filtersSelectedShops;
    }

    /**
     * @return \Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Shops
     */
    public function getFiltersShops()
    {
        return $this->filtersShops;
    }

    /**
     * @return \Nokaut\ApiKitBB\Entity\Metadata\Facet\PhraseFacet
     */
    public function getPhrase()
    {
        return $this->phrase;
    }
}