<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Collection\Categories;

class CategoriesConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Categories
     */
    public function convert(\stdClass $object)
    {
        $categoryConverter = new CategoryConverter();
        $entities = array();
        foreach ($object->categories as $categoryObject) {
            $entities[] = $categoryConverter->convert($categoryObject);
        }

        $categories = new Categories($entities);
        return $categories;
    }
}