<?php

namespace BuybloBox\Filter;

use BuybloBox\Entity\Product;
use Nokaut\ApiKitBB\Entity\Product\Property;
use Nokaut\BuybloApiKit\Entity\Group;

class GroupProductsPropertiesFilter
{
    /**
     * @param Group $group
     * @return Group
     */
    public static function filter(Group $group)
    {
        $propertiesIds = array();
        $propertiesByProductId = array();
        /** @var Product $product */
        foreach ($group->getProducts() as $product) {
            /** @var \Nokaut\ApiKitBB\Entity\Product $productEntity */
            $productEntity = $product->getEntity();

            foreach ($productEntity->getProperties() as $property) {
                $propertiesIds[$property->getId()] = $property;
                $propertiesByProductId[$productEntity->getId()][$property->getId()] = $property;
            }
        }

        /** @var Product $product */
        foreach ($group->getProducts() as $product) {
            /** @var \Nokaut\ApiKitBB\Entity\Product $productEntity */
            $productEntity = $product->getEntity();

            $productProperties = array();
            /** @var Property $property */
            foreach ($propertiesIds as $propertyId => $property) {
                if (isset($propertiesByProductId[$productEntity->getId()][$propertyId])) {
                    $productProperties[] = $propertiesByProductId[$productEntity->getId()][$propertyId];
                } else {
                    $fakeProperty = new Property();
                    $fakeProperty->setName($property->getName());
                    $productProperties[] = $fakeProperty;
                }
            }
            $productEntity->setProperties($productProperties);
        }

        return $group;
    }

    /**
     * @param Group[] $groups
     * @return Group[]
     */
    public static function filterGroups(array $groups)
    {
        $filteredGroups = array();
        /** @var Group $group */
        foreach ($groups as $group) {
            $filteredGroups[] = self::filter($group);
        }

        return $filteredGroups;
    }
}