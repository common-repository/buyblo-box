<?php


namespace Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Sort;


use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\FiltersAbstract;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\FilterAbstract;

class SortByName implements SortInterface
{
    public static function sort(FiltersAbstract $collection)
    {
        $entities = $collection->getEntities();

        usort($entities, function ($entity1, $entity2) {
            /** @var FilterAbstract $entity1 */
            /** @var FilterAbstract $entity2 */
            return strnatcmp(strtolower($entity1->getName()), strtolower($entity2->getName()));
        });

        $collection->setEntities($entities);
    }
} 