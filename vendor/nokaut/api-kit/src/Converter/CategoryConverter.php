<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.05.2014
 * Time: 15:46
 */

namespace Nokaut\ApiKitBB\Converter;


use Nokaut\ApiKitBB\Converter\Category\PathConverter;
use Nokaut\ApiKitBB\Entity\Category;
use Nokaut\ApiKitBB\Entity\Category\Path;

class CategoryConverter implements ConverterInterface
{

    public function convert(\stdClass $object)
    {
        $category = new Category();

        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObject($category, $field, $value);
            } else {
                $category->set($field, $value);
            }
        }
        return $category;
    }

    protected function convertSubObject(Category $category, $filed, $value)
    {
        switch ($filed) {
            case 'path':
                $category->setPath($this->convertPath($value));
                break;
        }
    }

    /**
     * @param $objectPathArray
     * @return Path[]
     */
    private function convertPath($objectPathArray)
    {
        $pathConverter = new PathConverter();
        $pathArray = array();

        foreach ($objectPathArray as $pathApiObject) {
            $pathArray[] = $pathConverter->convert($pathApiObject);
        }
        return $pathArray;
    }
} 