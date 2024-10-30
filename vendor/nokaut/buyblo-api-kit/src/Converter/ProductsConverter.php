<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Collection\Products;
use Nokaut\BuybloApiKit\Entity\Products\Metadata;

class ProductsConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Products
     */
    public function convert(\stdClass $object)
    {
        $productConverter = new ProductConverter();
        $entities = array();
        foreach ($object->products as $productObject) {
            $entities[] = $productConverter->convert($productObject);
        }

        $products = new Products($entities);
        if (isset($object->metadata)) {
            $products->setMetadata($this->convertMetadata($object->metadata));
        }

        return $products;
    }

    /**
     * @param $object
     * @return Metadata
     */
    protected function convertMetadata($object)
    {
        $metadata = new Metadata();
        if (isset($object->total)) {
            $metadata->setTotal($object->total);
        }

        return $metadata;
    }
}