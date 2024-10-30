<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 02.09.2014
 * Time: 10:52
 */

namespace Nokaut\ApiKitBB\Converter\Metadata\Facet;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\PhraseFacet;

class PhraseFacetConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $phraseFacet = new PhraseFacet();

        foreach ($object as $field => $value) {
            $phraseFacet->set($field, $value);
        }
        return $phraseFacet;
    }
} 