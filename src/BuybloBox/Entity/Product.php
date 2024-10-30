<?php
namespace BuybloBox\Entity;


class Product extends \Nokaut\BuybloApiKit\Entity\Product
{
    /**
     * @var \Nokaut\ApiKitBB\Entity\Product
     */
    protected $entity;

    /**
     * @return \Nokaut\ApiKitBB\Entity\Product
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param \Nokaut\ApiKitBB\Entity\Product $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
}