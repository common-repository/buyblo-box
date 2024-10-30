<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Shops;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\Shop;

class SetIsPopular implements CallbackInterface
{
    /**
     * @param Shops $shops
     * @param Products $products
     */
    public function __invoke(Shops $shops, Products $products)
    {
        $this->setShopsIsPopular($shops, $products);
    }

    /**
     * @param Shops $shops
     * @param Products $products
     */
    protected function setShopsIsPopular(Shops $shops, Products $products)
    {
        /** @var Shop $shop */
        foreach ($shops as $shop) {
            if ($products->getMetadata()->getTotal() > 0
                and $this->isPercentageOfShopInTotalGreatherThenPercent($shop, $products, 10)
                and $shop->getTotal() > 2
            ) {
                $shop->setIsPopular(true);
            } else {
                $shop->setIsPopular(false);
            }
        }
    }

    /**
     * @param Shop $shop
     * @param Products $products
     * @param float $percent
     * @return bool
     */
    protected function isPercentageOfShopInTotalGreatherThenPercent(Shop $shop, Products $products, $percent)
    {
        return $shop->getTotal() / $products->getMetadata()->getTotal() > ($percent / 100);
    }
}