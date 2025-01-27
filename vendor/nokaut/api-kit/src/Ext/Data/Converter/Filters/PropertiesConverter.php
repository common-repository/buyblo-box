<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\PropertyFacet\Range;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PropertyRanges;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PropertyValues;
use Nokaut\ApiKitBB\Ext\Data\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PropertyAbstract;
use Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Property\CallbackInterface;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\PropertyRange;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\PropertyValue;

class PropertiesConverter implements ConverterInterface
{
    /**
     * @var array
     */
    private static $cache = array();

    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return PropertyAbstract[]
     */
    public function convert(Products $products, $callbacks = array())
    {
        $propertiesInitialConverted = $this->initialConvert($products);
        $properties = array();

        foreach ($propertiesInitialConverted as $property) {
            foreach ($callbacks as $callback) {
                $callback($property, $products);
            }
            $properties[] = $property;
        }

        return $properties;
    }

    /**
     * @param Products $products
     * @return PropertyAbstract[]
     */
    protected function initialConvert(Products $products)
    {
        $cacheKey = md5($products->getMetadata()->getUrl());

        if (!isset(self::$cache[$cacheKey])) {
            $facetProperties = $products->getProperties();

            $properties = array();

            foreach ($facetProperties as $facetProperty) {
                $entities = array();
                if ($facetProperty->getRanges()) {
                    foreach ($facetProperty->getRanges() as $range) {
                        $entity = new PropertyRange();
                        $entity->setName($this->getPropertyRangeName($range));
                        $entity->setParam($range->getParam());
                        $entity->setUrl($range->getUrl());
                        $entity->setIsFilter($range->getIsFilter());
                        $entity->setTotal((int)$range->getTotal());
                        $entity->setMin($range->getMin());
                        $entity->setMax($range->getMax());
                        $entities[] = $entity;
                    }

                    $property = new PropertyRanges($entities);
                } else {
                    foreach ($facetProperty->getValues() as $value) {
                        $entity = new PropertyValue();
                        $entity->setName($value->getName());
                        $entity->setParam($value->getParam());
                        $entity->setUrl($value->getUrl());
                        $entity->setIsFilter($value->getIsFilter());
                        $entity->setTotal($value->getTotal());
                        $entities[] = $entity;
                    }

                    $property = new PropertyValues($entities);
                }

                $property->setUnit($facetProperty->getUnit());
                $property->setName($facetProperty->getName());
                $property->setUrlOut($facetProperty->getUrlOut());
                $property->setUrlInTemplate($facetProperty->getUrlInTemplate());
                $property->setId($facetProperty->getId());

                $properties[] = $property;
            }

            self::$cache[$cacheKey] = $properties;
        }

        return array_map(function ($collection) {
            return clone $collection;
        }, self::$cache[$cacheKey]);
    }

    /**
     * @param Range $range
     * @return string
     */
    protected function getPropertyRangeName(Range $range)
    {
        if ($range->getMin() == $range->getMax()) {
            return (string)$range->getMin();
        } else {
            return sprintf("%s - %s", $range->getMin(), $range->getMax());
        }
    }
} 