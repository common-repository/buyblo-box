<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Property;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\PriceFacet;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\ProducerFacet;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\ShopFacet;
use Nokaut\ApiKitBB\Entity\Product\Shop;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\FiltersAbstract;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PropertyAbstract;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\FilterAbstract;
use Nokaut\ApiKitBB\Ext\Lib\ProductsAnalyzer;

class SetIsNofollow implements CallbackInterface
{
    /**
     * @param PropertyAbstract $property
     * @param Products $products
     */
    public function __invoke(PropertyAbstract $property, Products $products)
    {
        $this->setPropertyIsNofollow($property, $products);
    }

    /**
     * @param PropertyAbstract $property
     * @param Products $products
     */
    protected function setPropertyIsNofollow(PropertyAbstract $property, Products $products)
    {
        if ($property->isPropertyRanges()) {
            /** @var FilterAbstract $value */
            foreach ($property as $value) {
                $value->setIsNofollow(true);
            }
            return;
        }

        // Jesli jakikolwiek poza biezacym property jest nofollow, to ten tez ma - nofollow
        if (ProductsAnalyzer::filtersNofollow($products, $property)) {
            /** @var FilterAbstract $value */
            foreach ($property as $value) {
                $value->setIsNofollow(true);
            }
            return;
        }

        $countOtherGroupsWithFilterSet = ProductsAnalyzer::countGroupsWithFilterSet($products, $property);

        if ($countOtherGroupsWithFilterSet >= 1) {
            /** @var FilterAbstract $value */
            foreach ($property as $value) {
                $value->setIsNofollow(true);
            }
            return;
        }

        $selectedFiltersEntitiesCount = $this->countSelectedFiltersEntities($property);

        // jesli wartosc numeryczna filtra: nofollow, chyba ze odklik z jedynego filtra
        $numericValueCount = 0;
        foreach ($property as $value) {
            if (is_numeric($value->getName())) {
                $numericValueCount++;
                if ($value->getIsFilter() and $selectedFiltersEntitiesCount == 1 and $countOtherGroupsWithFilterSet == 0) {
                    $value->setIsNofollow(false);
                } else {
                    $value->setIsNofollow(true);
                }
            }
        }

        if ($numericValueCount) {
            return;
        }

        // Jesli dany property ma zaznaczona jakas ceche
        // ale jesli jest filtrem to gdy ma zaznaczone wiecej niz dwie wartosci
        if ($selectedFiltersEntitiesCount >= 1) {
            /** @var FilterAbstract $value */
            foreach ($property as $value) {
                if ($value->getIsFilter() and $selectedFiltersEntitiesCount <= 2 and $countOtherGroupsWithFilterSet == 0) {
                    $value->setIsNofollow(false);
                } else {
                    $value->setIsNofollow(true);
                }
            }
            return;
        }

        /** @var FilterAbstract $value */
        foreach ($property as $value) {
            $value->setIsNofollow(false);
        }
    }

    /**
     * @param Products $products
     * @param PropertyAbstract $skipProperty
     * @return bool
     */
    protected function isAnyFacetNofollow(Products $products, PropertyAbstract $skipProperty = null)
    {
        if (count(array_filter($products->getShops(), function ($shop) {
                /** @var ShopFacet $shop */
                return $shop->getIsFilter();
            })) >= 2
        ) {
            return true;
        }

        if (count(array_filter($products->getProducers(), function ($producer) {
                /** @var ProducerFacet $producer */
                return $producer->getIsFilter();
            })) >= 2
        ) {
            return true;
        }

        if (count(array_filter($products->getPrices(), function ($priceRange) {
                /** @var PriceFacet $priceRange */
                return $priceRange->getIsFilter();
            })) >= 1
        ) {
            return true;
        }

        foreach ($products->getProperties() as $property) {
            if ($property->getRanges()) {
                if (count(array_filter($property->getRanges(), function ($range) {
                        return $range->getIsFilter();
                    })) >= 1
                ) {
                    if ($skipProperty and $property->getId() != $skipProperty->getId()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } elseif ($property->getValues()) {
                if (count(array_filter($property->getValues(), function ($range) {
                        return $range->getIsFilter();
                    })) >= 2
                ) {
                    if ($skipProperty and $property->getId() != $skipProperty->getId()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param PropertyAbstract $property
     * @return int
     */
    public function countSelectedFiltersEntities(PropertyAbstract $property)
    {
        return count($this->getSelectedFilterEntities($property));
    }

    /**
     * @param FiltersAbstract $property
     * @return FilterAbstract[]
     */
    protected function getSelectedFilterEntities(FiltersAbstract $property)
    {
        return array_filter($property->getEntities(), function ($entity) {
            /** @var FilterAbstract $entity */
            return $entity->getIsFilter();
        });
    }
} 