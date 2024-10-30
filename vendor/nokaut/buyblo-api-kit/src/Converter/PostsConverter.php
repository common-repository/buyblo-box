<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Collection\Posts;
use Nokaut\BuybloApiKit\Entity\Posts\Metadata;

class PostsConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Posts
     */
    public function convert(\stdClass $object)
    {
        $postConverter = new PostConverter();
        $entities = array();
        foreach ($object->posts as $postObject) {
            $entities[] = $postConverter->convert($postObject);
        }

        $posts = new Posts($entities);
        if (isset($object->metadata)) {
            $posts->setMetadata($this->convertMetadata($object->metadata));
        }
        return $posts;
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