<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 13:26
 */

namespace Nokaut\ApiKitBB\Converter\Metadata\Facet;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\CategoryFacet;

class CategoryFacetConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $categoryFacet = new CategoryFacet();

        foreach ($object as $field => $value) {
            $categoryFacet->set($field, $value);
        }
        return $categoryFacet;
    }
}