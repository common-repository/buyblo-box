<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\Post;

class PostConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Post
     */
    public function convert(\stdClass $object)
    {
        $post = new Post();
        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                switch ($field) {
                    case 'groups':
                        $post->setGroups($this->convertGroups($value));
                        break;
                    case 'photo':
                        $post->setPhoto($this->convertPhoto($value));
                        break;
                    case 'user':
                        $userConverter = new UserConverter();
                        $post->setUser($userConverter->convert($value));
                        break;
                }
            } else {
                switch ($field) {
                    case 'post_date':
                        $post->setPostDate(new \DateTime($value));
                        break;
                    case 'visibility_at':
                        $post->setPostDate(new \DateTime($value));
                        break;
                    default:
                        $post->set($field, $value);
                        break;
                }
            }
        }

        return $post;
    }

    /**
     * @param array $objects
     * @return array
     */
    protected function convertGroups(array $objects)
    {
        $groupConverter = new GroupConverter();
        $entities = array();

        foreach ($objects as $object) {
            $entities[] = $groupConverter->convert($object);
        }

        return $entities;
    }

    /**
     * @param $object
     * @return Post\Photo
     */
    protected function convertPhoto($object)
    {
        $photo = new Post\Photo();
        if (isset($object->url)) {
            $photo->setUrl($object->url);
        }
        if (isset($object->template)) {
            $photo->setTemplate($object->template);
        }
        if (isset($object->external_url)) {
            $photo->setExternalUrl($object->external_url);
        }
        if (isset($object->original_width)) {
            $photo->setOriginalWidth($object->original_width);
        }
        if (isset($object->original_height)) {
            $photo->setOriginalHeight($object->original_height);
        }

        return $photo;
    }
}