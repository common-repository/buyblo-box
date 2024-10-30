<?php


namespace Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Sort;


use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\FiltersAbstract;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\FilterAbstract;

class SortByTotal implements SortInterface
{
    public static function sort(FiltersAbstract $collection)
    {
        $entities = $collection->getEntities();

        usort($entities, function ($entity1, $entity2) {
            /** @var FilterAbstract $entity1 */
            /** @var FilterAbstract $entity2 */
            if ($entity1->getTotal() == $entity2->getTotal()) {
                return 0;
            }
            return ($entity1->getTotal() < $entity2->getTotal()) ? 1 : -1;
        });

        $collection->setEntities($entities);
    }
} 