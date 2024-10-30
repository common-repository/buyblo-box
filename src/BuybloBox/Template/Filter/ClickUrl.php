<?php
namespace BuybloBox\Template\Filter;

class ClickUrl
{
    const CLICK_BASE_URL = 'http://nokaut.click/';

    /**
     * @param $clickUrl
     * @param int|null $campaignId
     * @return string
     */
    public static function clickUrl($clickUrl, $campaignId = null)
    {
        $url = self::CLICK_BASE_URL . ltrim($clickUrl, "/");

        $campaignId = (int)$campaignId;
        if ($campaignId) {
            $url .= '&cid=' . $campaignId;
        }

        return $url;
    }
}