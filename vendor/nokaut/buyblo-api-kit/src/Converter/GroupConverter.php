<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\Category;
use Nokaut\BuybloApiKit\Entity\Group;
use Nokaut\BuybloApiKit\Entity\Post;
use Nokaut\BuybloApiKit\Entity\Product;

class GroupConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Group
     */
    public function convert(\stdClass $object)
    {
        $group = new Group();
        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                switch ($field) {
                    case 'category':
                        $group->setCategory($this->convertCategory($value));
                        break;
                    case 'products':
                        $group->setProducts($this->convertProducts($value));
                        break;
                    case 'posts':
                        $group->setPosts($this->convertPosts($value));
                        break;
                }
            } else {
                $group->set($field, $value);
            }
        }

        return $group;
    }

    /**
     * @param \stdClass $object
     * @return Category
     */
    protected function convertCategory(\stdClass $object)
    {
        $categoryConverter = new CategoryConverter();
        return $categoryConverter->convert($object);
    }

    /**
     * @param array $objects
     * @return Product[]
     */
    protected function convertProducts(array $objects)
    {
        $productConverter = new ProductConverter();

        $entities = array();
        foreach ($objects as $object) {
            $entities[] = $productConverter->convert($object);
        }

        return $entities;
    }

    /**
     * @param array $objects
     * @return Post[]
     */
    protected function convertPosts(array $objects)
    {
        $postConverter = new PostConverter();

        $entities = array();
        foreach ($objects as $object) {
            $entities[] = $postConverter->convert($object);
        }

        return $entities;
    }
}