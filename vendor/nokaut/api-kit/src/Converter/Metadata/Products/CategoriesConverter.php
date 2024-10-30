<?php

namespace Nokaut\ApiKitBB\Converter\Metadata\Products;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Metadata\Products\Categories;

class CategoriesConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Categories
     */
    public function convert(\stdClass $object)
    {
        $categories = new Categories();

        foreach ($object as $field => $value) {
            $categories->set($field, $value);
        }
        return $categories;
    }
}