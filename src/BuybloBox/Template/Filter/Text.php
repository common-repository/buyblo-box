<?php
namespace BuybloBox\Template\Filter;

class Text
{
    /**
     * @param string $title
     * @param int $length
     * @return string
     */
    public static function short($title, $length = 80)
    {
        if (strlen($title) > $length) {
            $title = substr($title, 0, $length) . '...';
        }

        return $title;
    }

    /**
     * @param float $price
     * @return string
     */
    public static function price($price)
    {
        if ($price != (int)$price) {
            $price = sprintf("%01.2f", $price);
        }

        return str_replace(".", ",", $price);
    }

    /**
     * @param float $price
     * @return string
     */
    public static function priceSup($price)
    {
        $priceParts = explode(",", number_format($price, 2, ',', ''));
        if ($priceParts[1] == '00') {
            $price = self::numberFormat($priceParts[0]);
        } else {
            $price = self::numberFormat($priceParts[0]) . ' <sup>' . $priceParts[1] . '</sup>';
        }
        return (string)$price;
    }

    /**
     * @param float $price
     * @return string
     */
    private static function numberFormat($price)
    {
        return number_format($price, 0, ',', '&nbsp;');
    }
}