<?php

namespace BuybloBox\Utils\ProductsSearch;


use BuybloBox\Utils\Pagination\Pagination;
use Nokaut\ApiKitBB\ClientApi\Rest\Exception\NotFoundException;
use Nokaut\ApiKitBB\ClientApi\Rest\Fetch\ProductsFetch;
use Nokaut\ApiKitBB\Collection\Categories;
use Nokaut\ApiKitBB\Collection\Producers;
use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Collection\Shops;
use Nokaut\ApiKitBB\Entity\Category;
use Nokaut\ApiKitBB\Entity\Category\Path;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\CategoryFacet;
use Nokaut\ApiKitBB\Entity\Metadata\Products\Sort;
use Nokaut\ApiKitBB\Entity\Producer;
use Nokaut\ApiKitBB\Entity\Product;
use Nokaut\ApiKitBB\Entity\Shop;
use Nokaut\ApiKitBB\Ext\Data;
use Nokaut\ApiKitBB\Ext\Data\Decorator\Products\Callback\SetProductsCategory;
use Nokaut\ApiKitBB\Ext\Data\Decorator\Products\ProductsDecorator;
use Nokaut\ApiKitBB\Repository\CategoriesAsyncRepository;
use Nokaut\ApiKitBB\Repository\ProducersRepository;
use Nokaut\ApiKitBB\Repository\ShopsRepository;
use NokautApiKitBuybloBox\Ext\Data\Converter\Filters\Callback\Categories\SelectedCategories;
use NokautApiKitBuybloBox\Ext\Data\Converter\Filters\Callback\Categories\UnselectedCategories;
use NokautApiKitBuybloBox\Repository\CategoriesRepository;
use NokautApiKitBuybloBox\Repository\ProductsAsyncRepository;
use NokautApiKitBuybloBox\Repository\ProductsRepository;

class SearchEngine
{
    const ROOT_CATEGORIES_FETCH_KEY = 100;

    /**
     * @var CategoriesRepository
     */
    private $categoriesRepository;

    /**
     * @var CategoriesAsyncRepository
     */
    private $categoriesAsyncRepository;

    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    /**
     * @var ProductsAsyncRepository
     */
    private $productsAsyncRepository;

    /**
     * @var ShopsRepository
     */
    private $shopsRepository;

    /**
     * @var ProducersRepository
     */
    private $producersRepository;

    /**
     * @var int
     */
    private $productsPageLimit;

    /**
     * @var int
     */
    private $searchQuality = 60;

    /**
     * SearchEngine constructor.
     * @param CategoriesRepository $categoriesRepository
     * @param CategoriesAsyncRepository $categoriesAsyncRepository
     * @param ProductsRepository $productsRepository
     * @param ProductsAsyncRepository $productsAsyncRepository
     * @param ShopsRepository $shopsRepository
     * @param ProducersRepository $producersRepository
     * @param int $productsPageLimit
     */
    public function __construct(
        CategoriesRepository $categoriesRepository,
        CategoriesAsyncRepository $categoriesAsyncRepository,
        ProductsRepository $productsRepository,
        ProductsAsyncRepository $productsAsyncRepository,
        ShopsRepository $shopsRepository,
        ProducersRepository $producersRepository,
        $productsPageLimit = 24
    )
    {
        $this->categoriesRepository = $categoriesRepository;
        $this->categoriesAsyncRepository = $categoriesAsyncRepository;
        $this->productsRepository = $productsRepository;
        $this->productsAsyncRepository = $productsAsyncRepository;
        $this->shopsRepository = $shopsRepository;
        $this->producersRepository = $producersRepository;
        $this->productsPageLimit = $productsPageLimit;
    }

    /**
     * @return InitData
     */
    public function getInitData()
    {
        $categoriesRoot = $this->categoriesRepository->fetchByParentId(0, CategoriesRepository::$fieldsForSelect);

        $initData = new InitData();
        $initData->setCategoriesRoot($categoriesRoot);

        return $initData;
    }

    /**
     * @param string $filterUrl
     * @return ProductsSearchResult
     */
    public function getProductsSearchResult($filterUrl)
    {
        $filterUrl = ltrim($filterUrl, '/');
        $category = $this->fetchCategory($filterUrl);

        $productsFetch = $this->productsAsyncRepository->fetchProductsByUrlWithQuality(
            $filterUrl, $this->getProductFields(), $this->productsPageLimit, $this->searchQuality
        );
        $categoriesByLevelsFetches = $category ? $this->getCategoriesByLevelsFetches($category, $filterUrl) : array();
        $this->productsAsyncRepository->fetchAllAsync();

        /** @var Products $products */
        $products = $productsFetch->getResult(true);
//        $this->checkProductsDataConsistency($products->getEntities());
//        $this->filter($products);
        $this->setProductsCategories($products);

        $unselectedCategoriesFilters = $this->getCategoriesUnselectedFilters($products);
        if ($unselectedCategoriesFilters->count() == 1) {
            return $this->getProductsSearchResult($unselectedCategoriesFilters->getLast()->getUrlIn());
        }

        $selectedCategoriesFilters = $this->getCategoriesSelectedFilters($products);
        if (!$category && $selectedCategoriesFilters->count() == 1) {
            /** @var Data\Entity\Filter\Category $categoryFilter */
            $categoryFilter = $selectedCategoriesFilters->getLast();
            $category = $this->fetchCategory($categoryFilter->getUrlIn());

            if ($category) {
                $categoriesByLevelsFetches = $this->getCategoriesByLevelsFetches($category, $filterUrl);
                $this->productsAsyncRepository->fetchAllAsync();
            }
        }

        $categoriesByLevels = $category ? $this->getCategoriesByLevels($categoriesByLevelsFetches, $category) : array();

        $filters = new Filters($products, $category);
        $url = $products->getMetadata()->getUrl();
        $pagination = $this->preparePagination($products);
        $sorts = $this->filterSorts($products ? $products->getMetadata()->getSorts() : array());

        $searchResult = new ProductsSearchResult();
        $searchResult->setUrl($url);
        $searchResult->setCategoriesByLevels($categoriesByLevels);
        $searchResult->setFilters($filters);
        $searchResult->setProducts($products);
        $searchResult->setSorts($sorts);
        $searchResult->setPagination($pagination);

        return $searchResult;
    }

    /**
     * @param string $filterPrefix
     * @return OptionsSearchResult
     */
    public function getShopsSearchResult($filterPrefix)
    {
        if ($filterPrefix) {
            $shops = $this->shopsRepository->fetchByNamePrefix($filterPrefix, ShopsRepository::$fieldsAutoComplete, 100);
        } else {
            $shops = new Shops(array());
        }

        $options = array();
        /** @var Shop $shop */
        foreach ($shops as $shop) {
            $option = new Option();
            $option->setId($shop->getProductsUrl());
            $option->setText($shop->getName());
            $options[] = $option;
        }

        $optionsSearchResult = new OptionsSearchResult();
        $optionsSearchResult->setOptions($options);

        return $optionsSearchResult;
    }

    /**
     * @param string $filterPrefix
     * @return OptionsSearchResult
     */
    public function getProducersSearchResult($filterPrefix)
    {
        if ($filterPrefix) {
            $producers = $this->producersRepository->fetchByNamePrefix($filterPrefix, ProducersRepository::$fieldsAutoComplete, 100);
        } else {
            $producers = new Producers(array());
        }

        $options = array();
        /** @var Producer $producer */
        foreach ($producers as $producer) {
            $option = new Option();
            $option->setId($producer->getProductsUrl());
            $option->setText($producer->getName());
            $options[] = $option;
        }

        $optionsSearchResult = new OptionsSearchResult();
        $optionsSearchResult->setOptions($options);

        return $optionsSearchResult;
    }

    /**
     * @param $filterUrl
     * @return Category
     */
    private function fetchCategory($filterUrl)
    {
        $filterUrl = ltrim($filterUrl, '/');
        $path = explode('/', $filterUrl);
        $categoryUrl = $path[0];
        try {
            $category = $this->categoriesRepository->fetchByUrl($categoryUrl, CategoriesRepository::$fieldsAll);
//            $this->filterCategory($category);
            return $category;
        } catch (NotFoundException $e) {
            return null;
        }
    }

    /**
     * @return array
     */
    protected function getProductFields()
    {
        $fields = ProductsRepository::$fieldsForList;
        $fields[] = '_categories.url_in';
        $fields[] = '_categories.url_base';
        $fields[] = 'shop.opineo_rating';
        $fields[] = '_properties.url_out';
        $fields[] = '_properties.url_in_template';
        $fields[] = '_properties.param';
        $fields[] = '_metadata.shops.url_out';
        $fields[] = '_metadata.shops.url_in_template';
        $fields[] = '_shops.param';
        $fields[] = '_metadata.producers.url_out';
        $fields[] = '_metadata.producers.url_in_template';
        $fields[] = '_producers.param';
        $fields[] = '_metadata.prices.url_out';
        $fields[] = '_metadata.prices.url_in_template';
        $fields[] = '_prices.param';
        $fields[] = 'properties.is_label';

        return $fields;
    }

    /**
     * @param Category $category
     * @param $categoryUrlWithFilters
     * @return \Nokaut\ApiKitBB\ClientApi\Rest\Fetch\ProductsFetch[]
     */
    private function getCategoriesByLevelsFetches(Category $category, $categoryUrlWithFilters)
    {
        $categoryUrlWithFiltersParts = explode('/', $categoryUrlWithFilters);

        if (count($categoryUrlWithFiltersParts) == 2 && $this->isFilterUrlValuable($categoryUrlWithFiltersParts[1])) {
            $filtersPathPart = '/' . end($categoryUrlWithFiltersParts);
        } else {
            $filtersPathPart = '';
        }

        $categoriesByLevelsFetches = array();
        if ($filtersPathPart) {
            $categoriesByLevelsFetches[0] = $this->productsAsyncRepository->fetchProductsForCategoryFacetByUrl(
                $filtersPathPart, ProductsAsyncRepository::CATEGORY_FACET_LEVEL_1, $this->searchQuality
            );
        } else {
            $categoriesByLevelsFetches[0] = $this->categoriesAsyncRepository->fetchByParentId(0, CategoriesRepository::$fieldsForSelect);
        }
        $path = $category->getPath();
        foreach ($path as $index => $pathNode) {
            if ($index < count($path) - 1) {
                $nodeUrlWithFilters = '/' . $pathNode->getUrl() . $filtersPathPart;
                $categoriesByLevelsFetches[$index + 1] = $this->productsAsyncRepository->fetchProductsForCategoryFacetByUrl(
                    $nodeUrlWithFilters, ProductsAsyncRepository::CATEGORY_FACET_RELATIVES, $this->searchQuality
                );
            }
        }

        if ($filtersPathPart) {
            $categoriesByLevelsFetches[self::ROOT_CATEGORIES_FETCH_KEY] = $this->categoriesAsyncRepository->fetchByParentId(0, CategoriesRepository::$fieldsForSelect);
        }

        return $categoriesByLevelsFetches;
    }

    /**
     * @param ProductsFetch[] $categoriesByLevelsFetches
     * @param Category $category
     * @return array
     * @throws \Exception
     */
    private function getCategoriesByLevels(array $categoriesByLevelsFetches, Category $category)
    {
        $categoriesByLevels = array();
        foreach ($categoriesByLevelsFetches as $index => $categoryByLevelFetch) {
            if ($index == self::ROOT_CATEGORIES_FETCH_KEY) {
                break;
            }

            $resultCollection = $categoryByLevelFetch->getResult();

            if ($index === 0 && $resultCollection === null) {
                $resultCollection = $categoriesByLevelsFetches[self::ROOT_CATEGORIES_FETCH_KEY]->getResult();
            }

            if ($resultCollection instanceof Products) {
                /** @var Products $resultCollection */
                /** @var CategoryFacet[] $categoryFacets */
                $categoryFacets = $resultCollection->getCategories();
                /**
                 * jesli nie dostalismy facet kategorii
                 * albo nie ma w nich kategorii z wezla
                 * to bierzemy kategorie wezla z path
                 */
                $path = $category->getPath();
                /** @var Path $pathCategory */
                $pathCategory = isset($path[$index]) ? $path[$index] : null;
                if ($pathCategory
                    && (!count($categoryFacets) || !$this->isCategoryInCategoryFacet($pathCategory->getId(), $categoryFacets))
                ) {
                    $categoryFacet = new CategoryFacet();
                    $categoryFacet->setId($pathCategory->getId());
                    $categoryFacet->setUrlIn($pathCategory->getUrl());
                    $categoryFacet->setName($pathCategory->getTitle());
                    $categoryFacets = array($categoryFacet);
                }
                $categoriesByLevels[$index] = $categoryFacets;
            } elseif ($resultCollection instanceof Categories) {
                $categoryFacets = array();
                /** @var Categories $resultCollection */
                /** @var Category $category */
                foreach ($resultCollection as $category) {
                    $categoryFacet = new CategoryFacet();
                    $categoryFacet->setId($category->getId());
                    $categoryFacet->setUrlIn($category->getUrl());
                    $categoryFacet->setName($category->getTitle());
                    $categoryFacets[] = $categoryFacet;
                }

                $categoriesByLevels[$index] = $categoryFacets;
            }
        }

        return $categoriesByLevels;
    }

    /**
     * @param $categoryId
     * @param array $categoryFacets
     * @return bool
     */
    private function isCategoryInCategoryFacet($categoryId, array $categoryFacets)
    {
        /** @var CategoryFacet $categoryFacet */
        foreach ($categoryFacets as $categoryFacet) {
            if ($categoryId == $categoryFacet->getId()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $products
     * @return Data\Collection\Filters\Categories
     */
    protected function getCategoriesUnselectedFilters($products)
    {
        $converterFilter = new Data\Converter\Filters\CategoriesConverter();
        $categoriesFilter = $converterFilter->convert($products, array(
            new UnselectedCategories(),
        ));
        return $categoriesFilter;
    }

    /**
     * @param $products
     * @return Data\Collection\Filters\Categories
     */
    protected function getCategoriesSelectedFilters($products)
    {
        $converterFilter = new Data\Converter\Filters\CategoriesConverter();
        $categoriesFilter = $converterFilter->convert($products, array(
            new SelectedCategories(),
        ));
        return $categoriesFilter;
    }

    /**
     * @param \Nokaut\ApiKitBB\Entity\Metadata\Products\Sort[] $sorts
     * @return \Nokaut\ApiKitBB\Entity\Metadata\Products\Sort[]
     */
    public function filterSorts($sorts)
    {
        $filteredSorts = array();
        $availableSorts = array(
            'najpopularniejsze' => 'Popularne',
            'najtansze' => 'Najtańsze',
            'najdrozsze' => 'Najdroższe',
            'od-a-do-z' => 'A-Z',
            'od-z-do-a' => 'Z-A',
        );

        /** @var Sort $sort */
        foreach ($sorts as $sort) {
            if (isset($availableSorts[$sort->getId()])) {
                $sort->setName($availableSorts[$sort->getId()]);
                $orderKey = array_search($sort->getId(), array_keys($availableSorts));
                $filteredSorts[$orderKey] = $sort;
            }
        }

        ksort($filteredSorts);
        return array_values($filteredSorts);
    }

    /**
     * @param Products $products
     * @return Pagination
     */
    protected function preparePagination($products)
    {
        if (is_null($products)) {
            return new Pagination();
        }
        $pagination = new Pagination();
        $pagination->setTotal($products->getMetadata()->getPaging()->getTotal());
        $pagination->setCurrentPage($products->getMetadata()->getPaging()->getCurrent());
        $pagination->setUrlFirstPage($products->getMetadata()->getPaging()->getUrlFirstPage());
        $pagination->setUrlTemplate($products->getMetadata()->getPaging()->getUrlTemplate());
        return $pagination;
    }

    /**
     * @param $filterUrlPart
     * @return bool
     */
    protected function isFilterUrlValuable($filterUrlPart)
    {
        return (bool)preg_match('/^(produkt:|producent:|sklep:|cena:)/', $filterUrlPart);
    }

    /**
     * @param Products $products
     * @param Categories $categories
     */
    protected function setProductsCategories(Products $products, Categories $categories = null)
    {
        if (!$categories) {
            $categories = $this->getUniqueProductsCategories($products);
        }
        $productsDecorator = new ProductsDecorator();
        $productsDecorator->decorate($products, array(
            new SetProductsCategory($categories)
        ));
    }

    /**
     * @param Products $products
     * @return Categories
     */
    protected function getUniqueProductsCategories(Products $products)
    {
        $categoryIds = array();

        /** @var $product Product */
        foreach ($products as $product) {
            $categoryIds[] = $product->getCategoryId();
        }

        $categoryIds = array_unique($categoryIds);
        $categories = $this->categoriesRepository->fetchCategoriesByIds($categoryIds, count($categoryIds), CategoriesRepository::$fieldsAll);

        return $categories;
    }
}