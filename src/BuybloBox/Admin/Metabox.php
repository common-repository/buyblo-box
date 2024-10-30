<?php

namespace BuybloBox\Admin;

use BuybloBox\BuybloApiKitFactory;
use BuybloBox\Exception\PostNotFoundException;
use BuybloBox\NokautApiKitFactory;
use BuybloBox\Repository\GroupsRepository;
use BuybloBox\Repository\PostsRepository;
use BuybloBox\Template\Renderer;
use BuybloBox\Utils\ProductsSearch\SearchEngine;
use Nokaut\BuybloApiKit\Entity\Post;
use Nokaut\ApiKitBB\Collection\Products;

class Metabox
{
    private static $initiated = false;
    private static $metaPrefix = 'buyblo_box_';
    private static $metaGroupsKey = 'groups';

    public static function init()
    {
        if (!self::$initiated) {
            self::initHooks();
        }
    }

    public static function initHooks()
    {
        self::$initiated = true;

        add_action('add_meta_boxes', array(__CLASS__, 'addMetaBox'));
        add_action('wp_insert_post', array(__CLASS__, 'saveMetaBoxData'));

        add_action('wp_ajax_buyblo_box_products_search', array(__CLASS__, 'ajaxProductsSearchCallback'));
        add_action('wp_ajax_buyblo_box_shops_search', array(__CLASS__, 'ajaxShopsSearchCallback'));
        add_action('wp_ajax_buyblo_box_producers_search', array(__CLASS__, 'ajaxProducersSearchCallback'));
        add_action('wp_ajax_buyblo_box_groups', array(__CLASS__, 'ajaxGroupsCallback'));
    }

    public static function addMetaBox()
    {
        if (null !== get_current_screen()) {
            $screen_id = get_current_screen()->id;
            add_filter("postbox_classes_{$screen_id}_buyblobox_meta", array(__CLASS__, 'metaBoxClass'));
        }

        $title = "BuyBlo Box";
        add_meta_box('buyblobox_meta', $title, array(__CLASS__, 'metaBox',), 'post', 'normal', 'high');
    }

    /**
     * @param array $classes
     * @return array
     */
    public static function metaBoxClass($classes)
    {
        $classes[] = 'buyblobox buyblobox-metabox';
        return $classes;
    }

    /**
     * @param $wpPost
     * @return string
     */
    public static function metaBox($wpPost)
    {
        try {
            if (!BuybloApiKitFactory::getApiKey()) {
                echo '<p>Wtyczka nie jest skonfigurowana, <a href="/wp-admin/options-general.php?page=buyblo-box-config">ustaw</a> klucz dostępu.</p>';
                return;
            }

            try {
                $postsRepository = new PostsRepository();
                $post = $postsRepository->fetchPostWithProductsEntities($wpPost->ID, true);
            } catch (PostNotFoundException $e) {
                $post = new Post();
            }

            $productsIdsGroupsJson = PostsRepository::convertPostToProductsIdsGroupsJson($post);
            $groupsHtml = self::renderPostGroups($post);
            $productsSearchHtml = self::renderProductsSearchStart();

            $context = array(
                'post' => $post,
                'groupsJson' => $productsIdsGroupsJson,
                'groupsHtml' => $groupsHtml,
                'productsSearchHtml' => $productsSearchHtml,
                'metaPrefix' => self::$metaPrefix,
                'metaGroupsKey' => self::$metaGroupsKey
            );

            echo Renderer::render('admin/post/metabox/metabox.twig', $context);
        } catch (\Exception $e) {
            $message = $e->getMessage() . ' in file ' . $e->getFile() . ':' . $e->getLine();
            echo '<p>Wystąpił błąd wtyczki. <!-- ' . $message . ' --></p>';
            error_log($message);
        }
    }

    public static function ajaxProductsSearchCallback()
    {
        $filterUrl = wp_unslash(trim($_POST['filterUrl']));
        $groupsJson = wp_unslash(trim($_POST['groupsJson']));

        $productsIdsGroups = json_decode($groupsJson, true);

        if (!trim($filterUrl, '/')) {
            $productsHtml = self::renderProductsSearchStart();
        } else {
            $searchEngine = self::getSearchEngine();
            $searchResult = $searchEngine->getProductsSearchResult($filterUrl);
            $context = array(
                'searchResult' => $searchResult,
                'groupsProductsIds' => self::flattenArray($productsIdsGroups)
            );
            $productsHtml = Renderer::render('admin/post/metabox/products-search/content.twig', $context);
        }

        $data = array(
            'productsHtml' => $productsHtml
        );

        echo json_encode($data);
        die();
    }

    public static function ajaxShopsSearchCallback()
    {
        $filterPrefix = wp_unslash(trim($_POST['filterPrefix']));
        $options = array();

        if ($filterPrefix) {
            try {
                $searchEngine = self::getSearchEngine();
                $optionsSearchResult = $searchEngine->getShopsSearchResult($filterPrefix);
                $options = $optionsSearchResult->getOptions();
            } catch (\Exception $e) {
            }
        }

        $data = array(
            'options' => $options
        );

        echo json_encode($data);
        die();
    }

    public static function ajaxProducersSearchCallback()
    {
        $filterPrefix = wp_unslash(trim($_POST['filterPrefix']));
        $options = array();

        if ($filterPrefix) {
            try {
                $searchEngine = self::getSearchEngine();
                $optionsSearchResult = $searchEngine->getProducersSearchResult($filterPrefix);
                $options = $optionsSearchResult->getOptions();
            } catch (\Exception $e) {
            }
        }

        $data = array(
            'options' => $options
        );

        echo json_encode($data);
        die();
    }

    /**
     * @return SearchEngine
     */
    private static function getSearchEngine()
    {
        $nokautApiKit = NokautApiKitFactory::getApiKit();
        $searchEngine = new SearchEngine(
            $nokautApiKit->getCategoriesRepository(),
            $nokautApiKit->getCategoriesAsyncRepository(),
            $nokautApiKit->getProductsRepository(),
            $nokautApiKit->getProductsAsyncRepository(),
            $nokautApiKit->getShopsRepository(),
            $nokautApiKit->getProducersRepository(),
            20
        );

        return $searchEngine;
    }

    private static function renderProductsSearchStart()
    {
        $searchEngine = self::getSearchEngine();
        $initData = $searchEngine->getInitData();
        $context = array('initData' => $initData);
        return Renderer::render('admin/post/metabox/products-search/start.twig', $context);
    }

    public static function ajaxGroupsCallback()
    {
        $groupsJson = wp_unslash(trim($_POST['groupsJson']));

        $productsIdsGroups = json_decode($groupsJson, true);

        $data = array();
        $data['groupsHtml'] = self::renderGroups($productsIdsGroups);

        echo json_encode($data);
        die();
    }

    /**
     * @param Post $post
     * @return string
     */
    public static function renderPostGroups(Post $post)
    {
        if (!count($post->getGroups())) {
            return '';
        }

        $context = array(
            'post' => $post,
            'edit_mode' => true
        );

        return Renderer::render('templates/default.twig', $context);
    }

    /**
     * @param array $productsIdsGroups
     * @return string
     */
    public static function renderGroups(array $productsIdsGroups)
    {
        if ($productsIdsGroups) {
            $post = new Post();
            $groupsRepository = new GroupsRepository();
            $groups = $groupsRepository->fetchGroupsByGroupsWithProductsEntities($productsIdsGroups);

            $post->setGroups($groups);
            return self::renderPostGroups($post);
        } else {
            return Renderer::render('admin/post/metabox/groups-not-found.twig');
        }
    }

    /**
     * @param Products $products
     * @param array $productsIdsGroups
     * @return string
     */
    public static function renderSearchProducts(Products $products, array $productsIdsGroups)
    {
        $context = array(
            'products' => $products,
            'groupsProductsIds' => self::flattenArray($productsIdsGroups)
        );

        return Renderer::render('admin/post/metabox/search-products.twig', $context);
    }

    /**
     * @param int $postId
     * @return bool
     */
    public static function saveMetaBoxData($postId)
    {
        if (is_multisite() && ms_is_switched()) {
            return false;
        }

        if ($postId === null) {
            return false;
        }

        if (wp_is_post_revision($postId)) {
            $postId = wp_is_post_revision($postId);
        }

        if (!isset($_POST['ID']) || $postId !== (int)$_POST['ID']) {
            return false;
        }

        clean_post_cache($postId);
        $wpPost = get_post($postId);
        if (!is_object($wpPost)) {
            return false;
        }

        try {
            $productsIdsGroups = array();
            if (isset($_POST[self::$metaPrefix . self::$metaGroupsKey])) {
                $productsIdsJson = wp_unslash($_POST[self::$metaPrefix . self::$metaGroupsKey]);
                $productsIdsGroups = json_decode($productsIdsJson, true);
            }

            $postsRepository = new PostsRepository();
            try {
                $post = $postsRepository->fetchPost($postId, true);
                self::setPostData($post, $postId, $productsIdsGroups);
                $postsRepository->updatePost($post);
            } catch (PostNotFoundException $e) {
                $post = new Post();
                self::setPostData($post, $postId, $productsIdsGroups);
                if ($post->getGroups()) {
                    $postsRepository->insertPost($post);
                }
            }
        } catch (\Exception $e) {
            error_log($e->getMessage() . ' in file ' . $e->getFile() . ':' . $e->getLine());
            return false;
        }

        return true;
    }

    /**
     * @param Post $post
     * @param int $postId
     * @param array $productsIdsGroups
     */
    private static function setPostData(Post $post, $postId, array $productsIdsGroups)
    {
        if (get_post_status($postId) == 'publish') {
            $post->setExternalVisibility(true);
        } else {
            $post->setExternalVisibility(false);
        }

        $post->setExternalId($postId);
        $post->setTitle(get_the_title($postId));
        $post->setContent(get_post_field('post_content', $postId, 'raw'));
        $post->setPostDate(new \DateTime(get_the_date('c', $postId)));

        $externalUrl = trim(parse_url(get_permalink($postId), PHP_URL_PATH), '/');
        if (!$externalUrl) {
            $externalUrl = $postId;
        }

        $post->setExternalUrl($externalUrl);
        $post->setRedirectUrl(get_permalink($postId));

        $photoUrl = wp_get_attachment_url(get_post_thumbnail_id($postId));
        $photo = new Post\Photo();
        if ($photoUrl) {
            $photo->setExternalUrl($photoUrl);
        }
        $post->setPhoto($photo);

        $post->setGroups(PostsRepository::preparePostPostChangeGroups($productsIdsGroups));
        $post->setType('wordpress');
    }

    /**
     * @param int $postId
     * @param string $key
     * @return bool|int
     */
    private static function updateValue($postId, $key)
    {
        $data = null;
        if (isset($_POST[self::$metaPrefix . $key])) {
            $data = $_POST[self::$metaPrefix . $key];
        }
        if (isset($data)) {
            return self::setValue($postId, $key, $data);
        } else {
            return self::deleteValue($postId, $key);
        }
    }

    /**
     * @param int $postId
     * @param string $key
     * @param bool $single
     * @return mixed
     */
    private static function getValue($postId, $key, $single)
    {
        return get_post_meta($postId, self::$metaPrefix . $key, $single);
    }

    /**
     * @param int $postId
     * @param string $key
     * @param string $value
     * @return bool|int
     */
    private static function setValue($postId, $key, $value)
    {
        return update_post_meta($postId, self::$metaPrefix . $key, $value);
    }

    /**
     * @param int $postId
     * @param string $key
     * @return bool
     */
    private static function deleteValue($postId, $key)
    {
        return delete_post_meta($postId, self::$metaPrefix . $key);
    }

    /**
     * @param array $array
     * @return array
     */
    private static function flattenArray(array $array)
    {
        return $array ? array_unique(call_user_func_array('array_merge', $array)) : array();
    }
}