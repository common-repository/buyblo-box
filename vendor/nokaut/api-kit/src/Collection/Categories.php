<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 23.06.2014
 * Time: 14:24
 */

namespace Nokaut\ApiKitBB\Collection;


use Nokaut\ApiKitBB\Entity\Category;

class Categories extends CollectionAbstract
{

    /**
     * @param int $index
     * @return Category
     */
    public function getItem($index)
    {
        return parent::getItem($index);
    }


} 