<?php

namespace NokautApiKitBuybloBox;

use NokautApiKitBuybloBox\Repository\CategoriesRepository;
use NokautApiKitBuybloBox\Repository\ProductsAsyncRepository;
use NokautApiKitBuybloBox\Repository\ProductsRepository;
use Nokaut\ApiKitBB\ApiKit;
use Nokaut\ApiKitBB\Config;

class NokautApiKitBuybloBox extends ApiKit
{
    /**
     * @param Config $config
     * @return ProductsRepository
     */
    public function getProductsRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new ProductsRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return ProductsAsyncRepository
     */
    public function getProductsAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new ProductsAsyncRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return CategoriesRepository
     */
    public function getCategoriesRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new CategoriesRepository($config, $restClientApi);
    }
}