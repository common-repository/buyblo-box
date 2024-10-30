<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 07:43
 */

namespace Nokaut\ApiKitBB\Converter\Category;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Category\Path;

class PathConverter implements ConverterInterface
{

    public function convert(\stdClass $object)
    {
        $path = new Path();
        foreach ($object as $field => $value) {
            $path->set($field, $value);
        }
        return $path;
    }

} 