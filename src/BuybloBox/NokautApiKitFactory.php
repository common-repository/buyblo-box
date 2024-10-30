<?php
namespace BuybloBox;

use NokautApiKitBuybloBox\NokautApiKitBuybloBox;
use BuybloBox\Logger\PrintHtml;
use Nokaut\ApiKitBB\Config;

class NokautApiKitFactory
{
    /**
     * @var NokautApiKitBuybloBox;
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
    protected static function getApiKey()
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
     * @return NokautApiKitBuybloBox
     */
    public static function getApiKit()
    {
        if (!self::$apiKit) {
            $config = new Config();
            $config->setApiAccessToken(self::getApiKey());
            $config->setApiUrl(self::getApiUrl());
            self::$apiKit = new NokautApiKitBuybloBox($config);
        }

        return self::$apiKit;
    }

    /**
     * @return NokautApiKitBuybloBox
     */
    public static function getApiKitInDebugMode()
    {
        $config = new Config();
        $config->setApiAccessToken(self::getApiKey());
        $config->setApiUrl(self::getApiUrl());
        $config->setLogger(new PrintHtml());
        return new NokautApiKitBuybloBox($config);
    }
} 