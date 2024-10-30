<?php

namespace Nokaut\BuybloApiKit;

use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\BuybloApiKit\ClientApi\Rest\RestClientApi;
use Nokaut\BuybloApiKit\Repository\CategoriesAsyncRepository;
use Nokaut\BuybloApiKit\Repository\CategoriesRepository;
use Nokaut\BuybloApiKit\Repository\GroupsRepository;
use Nokaut\BuybloApiKit\Repository\NotificationsRepository;
use Nokaut\BuybloApiKit\Repository\PostsAsyncRepository;
use Nokaut\BuybloApiKit\Repository\PostsRepository;
use Nokaut\BuybloApiKit\Repository\ProductsAsyncRepository;
use Nokaut\BuybloApiKit\Repository\ProductsRepository;
use Nokaut\BuybloApiKit\Repository\StatusRepository;
use Nokaut\BuybloApiKit\Repository\SubscriptionsRepository;
use Nokaut\BuybloApiKit\Repository\UsersAsyncRepository;
use Nokaut\BuybloApiKit\Repository\UsersRepository;

class BuybloApiKit
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Config $config
     */
    protected function validate(Config $config)
    {
        $config->validate();
    }

    /**
     * @param Config $config
     * @return RestClientApi
     */
    public function getClientApi(Config $config)
    {
        $oauth2 = new Oauth2Plugin();
        $accessToken = array(
            'access_token' => $config->getApiAccessToken()
        );
        $oauth2->setAccessToken($accessToken);
        return new RestClientApi($config->getLogger(), $oauth2, $config->getHeaders());
    }

    /**
     * @param Config $config
     * @return StatusRepository
     */
    public function getStatusRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new StatusRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return PostsRepository
     */
    public function getPostsRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new PostsRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return PostsAsyncRepository
     */
    public function getPostsAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new PostsAsyncRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return GroupsRepository
     */
    public function getGroupsRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new GroupsRepository($config, $restClientApi);
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

    /**
     * @param Config $config
     * @return CategoriesAsyncRepository
     */
    public function getCategoriesAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new CategoriesAsyncRepository($config, $restClientApi);
    }

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
     * @return SubscriptionsRepository
     */
    public function getSubscriptionsRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new SubscriptionsRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return NotificationsRepository
     */
    public function getNotificationsRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new NotificationsRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return UsersRepository
     */
    public function getUsersRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new UsersRepository($config, $restClientApi);
    }

    /**
     * @param Config $config
     * @return UsersAsyncRepository
     */
    public function getUsersAsyncRepository(Config $config = null)
    {
        if (!$config) {
            $config = $this->config;
        }
        $this->validate($config);

        $restClientApi = $this->getClientApi($config);

        return new UsersAsyncRepository($config, $restClientApi);
    }
}