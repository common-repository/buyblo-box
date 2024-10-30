<?php
namespace BuybloBox\Repository;

use BuybloApiKitBuybloBox\BuybloApiKitBuybloBox;
use BuybloBox\BuybloApiKitFactory;
use BuybloBox\Entity\Product;
use BuybloBox\Filter\GroupProductsPropertiesFilter;
use Nokaut\BuybloApiKit\Entity\Group;

class GroupsRepository
{
    /**
     * @var BuybloApiKitBuybloBox
     */
    private $buybloApiKit;

    public function __construct()
    {
        $this->buybloApiKit = BuybloApiKitFactory::getApiKit();
    }

    /**
     * @param array $idsGroups
     * @return Group[]
     */
    public function fetchGroupsByGroupsWithProductsEntities(array $idsGroups)
    {
        $idsGroups = array_values($idsGroups); //reset indexes
        $apiGroupsRepository = $this->buybloApiKit->getGroupsRepository();
        $groups = $apiGroupsRepository->fetchByGroups($idsGroups, \Nokaut\BuybloApiKit\Repository\GroupsRepository::$fieldsAll);
        $groups = $this->decorateGroupsWithProductEntities($groups->getEntities());
        $groups = GroupProductsPropertiesFilter::filterGroups($groups);
        return $groups;
    }

    /**
     * @param Group[] $groups
     * @return Group[]
     */
    public function decorateGroupsWithProductEntities(array $groups)
    {
        $products = $this->fetchGroupsProductsEntities($groups);
        $decoratedGroups = array();
        foreach ($groups as $group) {
            $productsWithEntities = array();
            foreach ($group->getProducts() as $product) {
                $productWithEntity = new Product();
                $productWithEntity->setId($product->getId());
                $productWithEntity->setType($product->getType());

                if (isset($products[$product->getId()])) {
                    $productWithEntity->setEntity($products[$product->getId()]);
                    $productsWithEntities[] = $productWithEntity;
                }
            }

            if ($productsWithEntities) {
                $group->setProducts($productsWithEntities);
                $decoratedGroups[] = $group;
            }
        }

        return $decoratedGroups;
    }

    /**
     * @param Group[] $groups
     * @return [productId => \Nokaut\ApiKitBB\Entity\Product]
     */
    private function fetchGroupsProductsEntities(array $groups)
    {
        $ids = array();
        foreach ($groups as $group) {
            /** @var Product $product */
            foreach ($group->getProducts() as $product) {
                $ids[] = $product->getId();
            }
        }

        /** @todo mniej produktów? rozjazd buyblo - products? wygasły? */

        $products = new ProductsRepository();
        return $products->fetchProductsByIdsWithIdKeys($ids);
    }
}