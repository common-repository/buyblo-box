<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\Product;

class ProductConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Product
     */
    public function convert(\stdClass $object)
    {
        $product = new Product();

        foreach ($object as $field => $value) {
            if (!is_object($value) && !is_array($value)) {
                $product->set($field, $value);
            }
        }

        return $product;
    }
}