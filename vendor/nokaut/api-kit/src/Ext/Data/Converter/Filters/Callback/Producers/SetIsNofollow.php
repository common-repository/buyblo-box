<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Producers;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\Producer;
use Nokaut\ApiKitBB\Ext\Lib\ProductsAnalyzer;

class SetIsNofollow implements CallbackInterface
{
    /**
     * @param Producers $producers
     * @param Products $products
     */
    public function __invoke(Producers $producers, Products $products)
    {
        $this->setProducersIsNofollow($producers, $products);
    }

    /**
     * @param Producers $producers
     * @param Products $products
     */
    protected function setProducersIsNofollow(Producers $producers, Products $products)
    {
        if (ProductsAnalyzer::filtersNofollow($products, $producers)) {
            /** @var Producer $producer */
            foreach ($producers as $producer) {
                $producer->setIsNofollow(true);
            }

            return;
        }

        $countOtherGroupsWithFilterSet = ProductsAnalyzer::countGroupsWithFilterSet($products,$producers);

        if($countOtherGroupsWithFilterSet >=1 ){
            /** @var Producer $producer */
            foreach ($producers as $producer) {
                $producer->setIsNofollow(true);
            }

            return;
        }

        $selectedProducerEntitiesCount = count($this->getSelectedProducerEntities($producers));
        if ($selectedProducerEntitiesCount >= 1) {
            /** @var Producer $producer */
            foreach ($producers as $producer) {
                if ($producer->getIsFilter()) {
                    if ($selectedProducerEntitiesCount <= 2 and $countOtherGroupsWithFilterSet == 0) {
                        $producer->setIsNofollow(false);
                    } else {
                        $producer->setIsNofollow(true);
                    }
                } else {
                    $producer->setIsNofollow(true);
                }
            }

            return;
        }
    }

    /**
     * @param Producers $producers
     * @return Producer[]
     */
    protected function getSelectedProducerEntities(Producers $producers)
    {
        return array_filter($producers->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        });
    }
}