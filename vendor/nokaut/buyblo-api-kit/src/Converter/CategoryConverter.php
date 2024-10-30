<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\Category;

class CategoryConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Category
     */
    public function convert(\stdClass $object)
    {
        $category = new Category();

        foreach ($object as $field => $value) {
            if (!is_object($value) && !is_array($value)) {
                $category->set($field, $value);
            }
        }

        return $category;
    }
}