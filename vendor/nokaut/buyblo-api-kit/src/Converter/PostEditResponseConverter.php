<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\Post;

class PostEditResponseConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Post
     */
    public function convert(\stdClass $object)
    {
        if (isset($object->post)) {
            if (isset($object->post->id)) {
                return $object->post->id;
            }
        }
    }
}