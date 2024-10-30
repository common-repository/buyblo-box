<?php

namespace BuybloBox\Template\Filter;


class ProductsSearchUrl
{
    public static function productsSearchUrl($argumentUrl)
    {
        $argumentUrl = ltrim($argumentUrl, '/');

        if ($argumentUrl && strstr($argumentUrl, '.html') === false && strstr($argumentUrl, '/') === false) {
            $argumentUrl = rtrim($argumentUrl, '/') . '/';
        }

        return $argumentUrl;
    }
}