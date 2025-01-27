<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PropertyAbstract;
use Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Property\CallbackInterface;
use Nokaut\ApiKitBB\Ext\Data\Converter\Filters\PropertiesConverter as PropertiesConverterParent;
use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\FilterAbstract;

class PropertiesConverter extends PropertiesConverterParent
{
    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return PropertyAbstract[]
     */
    public function convert(Products $products, $callbacks = array())
    {
        $propertiesInitialConverted = parent::convert($products, array());
        $properties = array();

        foreach ($propertiesInitialConverted as $property) {
            $selectedFilterEntities = array_filter($property->getEntities(), function ($entity) {
                /** @var FilterAbstract $entity */
                return $entity->getIsFilter();
            });

            if (count($selectedFilterEntities) === 0) {
                continue;
            }

            $property->setEntities($selectedFilterEntities);

            foreach ($callbacks as $callback) {
                $callback($property, $products);
            }

            $properties[] = $property;
        }

        return $properties;
    }
}