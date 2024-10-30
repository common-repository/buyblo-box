<?php
namespace BuybloBox\Repository;

use BuybloApiKitBuybloBox\BuybloApiKitBuybloBox;
use BuybloBox\BuybloApiKitFactory;
use BuybloBox\Entity\Product;
use BuybloBox\Exception\PostNotFoundException;
use BuybloBox\Filter\GroupProductsPropertiesFilter;
use Nokaut\BuybloApiKit\Entity\Group;
use Nokaut\BuybloApiKit\Entity\Post;

class PostsRepository
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
     * @param int $externalId
     * @param bool $visibilityAll
     * @return Post
     * @throws PostNotFoundException
     */
    public function fetchPost($externalId, $visibilityAll = false)
    {
        if (!$externalId) {
            throw new PostNotFoundException('External id not set');
        }

        $apiPostRepository = $this->buybloApiKit->getPostsRepository();
        $post = $apiPostRepository->fetchOneByExternalId($externalId, \Nokaut\BuybloApiKit\Repository\PostsRepository::$fieldsAll, $visibilityAll);

        if (!$post) {
            throw new PostNotFoundException('post not found');
        }

        $groupsRepository = new GroupsRepository();
        if($post->getGroups()) {
            $post->setGroups($groupsRepository->decorateGroupsWithProductEntities($post->getGroups()));
            $post->setGroups(GroupProductsPropertiesFilter::filterGroups($post->getGroups()));
        }

        return $post;
    }

    /**
     * @param int $externalId
     * @param bool $visibilityAll
     * @return Post
     */
    public function fetchPostWithProductsEntities($externalId, $visibilityAll = false)
    {
        $post = $this->fetchPost($externalId, $visibilityAll);

        $groupsRepository = new GroupsRepository();
        if($post->getGroups()) {
            $post->setGroups($groupsRepository->decorateGroupsWithProductEntities($post->getGroups()));
            $post->setGroups(GroupProductsPropertiesFilter::filterGroups($post->getGroups()));
        }
        return $post;
    }

    /**
     * @param Post $post
     * @return int
     */
    public function updatePost(Post $post)
    {
        $apiPostRepository = $this->buybloApiKit->getPostsRepository();
        return $apiPostRepository->updatePost($post);
    }

    /**
     * @param Post $post
     * @return int
     */
    public function insertPost(Post $post)
    {
        $apiPostRepository = $this->buybloApiKit->getPostsRepository();
        return $apiPostRepository->insertPost($post);
    }

    /**
     * @param Post $post
     * @return string
     */
    public static function convertPostToProductsIdsGroupsJson(Post $post)
    {
        $productsIdsGroups = array();

        if ($post) {
            foreach ($post->getGroups() as $postGroup) {
                $group = array();
                $groupCategoryId = null;
                /** @var \BuybloBox\Entity\Product $product */
                foreach ($postGroup->getProducts() as $product) {
                    if ($product->isManual()) {
                        $group[] = $product->getId();
                        if (!$groupCategoryId) {
                            $groupCategoryId = $product->getEntity()->getCategoryId();
                        }
                    }
                }
                if ($group && $groupCategoryId) {
                    $productsIdsGroups[(string)$groupCategoryId] = $group;
                }
            }
        }

        return json_encode($productsIdsGroups);
    }

    /**
     * @param array $productsIdsGroups
     * @return array
     */
    public static function preparePostPostChangeGroups(array $productsIdsGroups)
    {
        $groups = array();

        foreach ($productsIdsGroups as $categoryId => $productsIds) {
            $group = new Group();
            $tmpProductsIds = array();
            /** @var Product $product */
            foreach ($productsIds as $productId) {
                $bbProduct = new Product();
                $bbProduct->setId($productId);
                $bbProduct->setType(Product::TYPE_MANUAL);
                $tmpProductsIds[] = $bbProduct;
            }
            $group->setProducts($tmpProductsIds);
            $groups[] = $group;
        }

        return $groups;
    }
}