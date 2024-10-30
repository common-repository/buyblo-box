<?php

namespace BuybloBox;

use BuybloApiKitBuybloBox\BuybloApiKitBuybloBox;
use BuybloBox\Logger\PrintHtml;
use Nokaut\BuybloApiKit\Config;

class BuybloApiKitFactory
{
    /**
     * @var BuybloApiKitBuybloBox;
     */
    protected static $apiKit;

    /**
     * @var string
     */
    protected static $apiKey;

    /**
     * @var string
     */
    protected static $apiUrl;

    /**
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * @param string $apiUrl
     */
    public static function setApiUrl($apiUrl)
    {
        self::$apiUrl = $apiUrl;
    }

    /**
     * @return string
     */
    protected static function getApiUrl()
    {
        return self::$apiUrl;
    }

    /**
     * @return BuybloApiKitBuybloBox
     */
    public static function getApiKit()
    {
        if (!self::$apiKit) {
            $config = new Config();
            $config->setApiAccessToken(self::getApiKey());
            $config->setApiUrl(self::getApiUrl());
            $config->setHeaders(array('X-Plugin-Version' => 'BuyBloBox' . BUYBLO_BOX_VERSION));
            self::$apiKit = new BuybloApiKitBuybloBox($config);
        }

        return self::$apiKit;
    }

    /**
     * @return BuybloApiKitBuybloBox
     */
    public static function getApiKitInDebugMode()
    {
        $config = new Config();
        $config->setApiAccessToken(self::getApiKey());
        $config->setApiUrl(self::getApiUrl());
        $config->setHeaders(array('X-Plugin-Version' => 'BuyBloBox' . BUYBLO_BOX_VERSION));
        $config->setLogger(new PrintHtml());
        return new BuybloApiKitBuybloBox($config);
    }
}