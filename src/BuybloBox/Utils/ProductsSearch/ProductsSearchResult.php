<?php

namespace BuybloBox\Utils\ProductsSearch;


use BuybloBox\Utils\Pagination\Pagination;
use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\CategoryFacet;

class ProductsSearchResult
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var CategoryFacet[]
     */
    private $categoriesByLevels;

    /**
     * @var Filters
     */
    private $filters;

    /**
     * @var Products
     */
    private $products;

    /**
     * @var \Nokaut\ApiKitBB\Entity\Metadata\Products\Sort[]
     */
    private $sorts;

    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return CategoryFacet[]
     */
    public function getCategoriesByLevels()
    {
        return $this->categoriesByLevels;
    }

    /**
     * @param CategoryFacet[] $categoriesByLevels
     */
    public function setCategoriesByLevels(array $categoriesByLevels)
    {
        $this->categoriesByLevels = $categoriesByLevels;
    }

    /**
     * @return Filters
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param Filters $filters
     */
    public function setFilters(Filters $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return Products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Products $products
     */
    public function setProducts(Products $products)
    {
        $this->products = $products;
    }

    /**
     * @return \Nokaut\ApiKitBB\Entity\Metadata\Products\Sort[]
     */
    public function getSorts()
    {
        return $this->sorts;
    }

    /**
     * @param \Nokaut\ApiKitBB\Entity\Metadata\Products\Sort[] $sorts
     */
    public function setSorts(array $sorts)
    {
        $this->sorts = $sorts;
    }

    /**
     * @return Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param Pagination $pagination
     */
    public function setPagination(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }
}