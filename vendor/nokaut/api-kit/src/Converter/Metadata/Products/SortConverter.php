<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 09:36
 */

namespace Nokaut\ApiKitBB\Converter\Metadata\Products;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Metadata\Products\Sort;

class SortConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $sort = new Sort();

        foreach ($object as $field => $value) {
            $sort->set($field, $value);
        }

        return $sort;
    }

} 