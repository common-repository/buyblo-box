<?php
namespace BuybloBox\Repository;

use BuybloBox\NokautApiKitFactory;
use NokautApiKitBuybloBox\NokautApiKitBuybloBox;

class CategoriesRepository
{
    /**
     * @var NokautApiKitBuybloBox
     */
    private $nokautApiKit;

    public function __construct()
    {
        $this->nokautApiKit = NokautApiKitFactory::getApiKit();
    }

    /**
     * @return \Nokaut\ApiKitBB\Collection\Categories
     */
    public function fetchRootCategories()
    {
        $categoriesRepository = $this->nokautApiKit->getCategoriesRepository();
        return $categoriesRepository->fetchMenuCategories();
    }
}