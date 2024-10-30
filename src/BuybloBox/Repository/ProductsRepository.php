<?php
namespace BuybloBox\Repository;

use BuybloBox\NokautApiKitFactory;
use NokautApiKitBuybloBox\NokautApiKitBuybloBox;

class ProductsRepository
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
     * @param string $categoryUrl
     * @param string $phrase
     * @return \Nokaut\ApiKitBB\Collection\Products
     */
    public function fetchProducts($categoryUrl, $phrase)
    {
        $productsRepository = $this->nokautApiKit->getProductsRepository();

        $url = '';
        if ($categoryUrl) {
            $url .= rtrim($categoryUrl, '/') . '/';
        }

        $phrase = trim($phrase);
        if ($phrase) {
            $url .= 'produkt:' . $phrase . '.html';
        }

        $products = $productsRepository->fetchProductsByUrl($url, \Nokaut\ApiKitBB\Repository\ProductsRepository::$fieldsForProductBox, 10);

        self::fillProductsCategories($products);

        return $products;
    }

    public function fetchProductsByIdsWithIdKeys(array $ids)
    {
        $productsRepository = $this->nokautApiKit->getProductsRepository();
        $products = $productsRepository->fetchProductsByIds($ids, \Nokaut\ApiKitBB\Repository\ProductsRepository::$fieldsForProductPage, true);

        $productsIdMap = array();
        /** @var \Nokaut\ApiKitBB\Entity\Product $product */
        foreach ($products as $product) {
            $productsIdMap[$product->getId()] = $product;
        }

        return $productsIdMap;
    }

    /**
     * @param \Nokaut\ApiKitBB\Collection\Products $products
     */
    private function fillProductsCategories(\Nokaut\ApiKitBB\Collection\Products $products)
    {
        if (count($products)) {
            $categoriesIds = array_reduce($products->getEntities(), function ($categoryIds = array(), \Nokaut\ApiKitBB\Entity\Product $product) {
                $categoryIds[] = $product->getCategoryId();
                return $categoryIds;
            });
            $categoriesIds = array_unique($categoriesIds);

            $categoriesRepository = $this->nokautApiKit->getCategoriesRepository();
            $categories = $categoriesRepository->fetchCategoriesByIds($categoriesIds);

            $categoriesById = array();
            /** @var \Nokaut\ApiKitBB\Entity\Category $category */
            foreach ($categories as $category) {
                $categoriesById[$category->getId()] = $category;
            }

            $filteredProducts = array();
            /** @var \Nokaut\ApiKitBB\Entity\Product $product */
            foreach ($products as $product) {
                $category = isset($categoriesById[$product->getCategoryId()]) ? $categoriesById[$product->getCategoryId()] : null;

                if ($category) {
                    $product->setCategory($category);
                    $filteredProducts[] = $product;
                }
            }

            $products->setEntities($filteredProducts);
            $products->getMetadata()->setTotal(count($filteredProducts));
        }
    }
}