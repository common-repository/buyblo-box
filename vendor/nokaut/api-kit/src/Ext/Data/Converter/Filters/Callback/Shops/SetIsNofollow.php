<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Shops;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\Shop;
use Nokaut\ApiKitBB\Ext\Lib\ProductsAnalyzer;

class SetIsNofollow implements CallbackInterface
{
    /**
     * @param Shops $shops
     * @param Products $products
     */
    public function __invoke(Shops $shops, Products $products)
    {
        $this->setShopsIsNofollow($shops, $products);
    }

    /**
     * @param Shops $shops
     * @param Products $products
     */
    protected function setShopsIsNofollow(Shops $shops, Products $products)
    {
        if (ProductsAnalyzer::filtersNofollow($products, $shops)) {
            /** @var Shop $shop */
            foreach ($shops as $shop) {
                $shop->setIsNofollow(true);
            }

            return;
        }

        $countOtherGroupsWithFilterSet = ProductsAnalyzer::countGroupsWithFilterSet($products,$shops);

        if($countOtherGroupsWithFilterSet >=1 ){
            /** @var Shop $shop */
            foreach ($shops as $shop) {
                $shop->setIsNofollow(true);
            }

            return;
        }

        $selectedShopEntitiesCount = count($this->getSelectedShopEntities($shops));
        if ($selectedShopEntitiesCount >= 1) {
            /** @var Shop $shop */
            foreach ($shops as $shop) {
                if ($shop->getIsFilter()) {
                    if ($selectedShopEntitiesCount <= 2 and $countOtherGroupsWithFilterSet == 0) {
                        $shop->setIsNofollow(false);
                    } else {
                        $shop->setIsNofollow(true);
                    }
                } else {
                    $shop->setIsNofollow(true);
                }
            }

            return;
        }
    }

    /**
     * @param Shops $shops
     * @return Shop[]
     */
    protected function getSelectedShopEntities(Shops $shops)
    {
        return array_filter($shops->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        });
    }
}