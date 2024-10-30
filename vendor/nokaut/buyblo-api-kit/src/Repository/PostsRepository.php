<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\Cache\NullCache;
use Nokaut\BuybloApiKit\ClientApi\Rest\Exception\FatalResponseException;
use Nokaut\BuybloApiKit\ClientApi\Rest\Exception\UnprocessableEntityException;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\PostEditFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\PostsFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\SingleWithOperator;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\PostsQuery;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Collection\Posts;
use Nokaut\BuybloApiKit\Converter\PostEditBodyConverter;
use Nokaut\BuybloApiKit\Entity\Post;

class PostsRepository extends RepositoryAbstract
{
    /**
     * @var array
     */
    public static $fieldsAll = array(
        'id',
        'type',
        'external_id',
        'url',
        'redirect_url',
        'title',
        'excerpt',
        'excerpt_short',
        'content',
        'post_date',
        'photo.url',
        'photo.template',
//        'photo.external_url',
//        'photo.original_width',
//        'photo.original_height',
        'visibility',
        'user.id',
        'user.pid',
        'user.region',
        'user.slug',
        'user.title',
        'user.description',
        'user.url',
        'user.logo_url',
        'user.logo_template',
        'user.facebook_url',
        'user.instagram_url',
        'groups.category.id',
        'groups.category.title',
        'groups.category.url',
        'groups.products.id',
        'groups.products.type',
        'metadata.total',
//        'external_change_allowed',
//        'subscription_id',
//        'visibility_at',
    );

    public static $fieldsForList = array(
        'id',
        'type',
        'external_id',
        'url',
        'title',
        'excerpt',
        'excerpt_short',
        'post_date',
        'photo.url',
        'photo.template',
        'user.id',
        'user.pid',
        'user.region',
        'user.slug',
        'user.title',
        'user.description',
        'user.url',
        'user.logo_url',
        'user.logo_template',
        'user.facebook_url',
        'user.instagram_url',
        'groups.category.id',
        'groups.category.title',
        'groups.category.url',
        'metadata.total',
    );

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return PostsQuery
     */
    protected function getPostsQuery(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = new PostsQuery($this->apiBaseUrl);
        $query->setFields($fields);

        if ($limit !== null) {
            $query->setLimit($limit);
        }

        if ($offset !== null) {
            $query->setOffset($offset);
        }

        if ($sort !== null) {
            $query->addSort($sort);
        }

        if ($filters) {
            foreach ($filters as $filter) {
                $query->addFilter($filter);
            }
        }

        return $query;
    }

    /**
     * @param PostsQuery $query
     * @return PostsFetch
     */
    protected function getPostsFetch(PostsQuery $query)
    {
        return new PostsFetch($query, $this->cache);
    }

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @param string|null $contextUserId
     * @return Posts
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $query = $this->getPostsQuery($fields, $filters, $limit, $offset, $sort);
        $query->setContextUserId($contextUserId);
        $fetch = $this->getPostsFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $id
     * @param array $fields
     * @param bool $visibilityAll
     * @return Post
     */
    public function fetchOneById($id, array $fields, $visibilityAll = false)
    {
        $fetch = $this->prepareFetchOneById($id, $fields, $visibilityAll);
        $this->clientApi->send($fetch);
        return $this->fetchOne($fetch);
    }

    /**
     * @param string $id
     * @param array $fields
     * @param bool $visibilityAll
     * @return PostsFetch
     */
    protected function prepareFetchOneById($id, array $fields, $visibilityAll = false)
    {
        $query = $this->getPostsQuery($fields, array(new Single('id', $id)));
        if ($visibilityAll) {
            $query->addFilter(new Single('visibility', 'all'));
        }
        return $this->getPostsFetch($query);
    }

    /**
     * @param string $userId
     * @param string $id
     * @param array $fields
     * @param bool $visibilityAll
     * @return Post
     */
    public function fetchOneByUserIdAndId($userId, $id, array $fields, $visibilityAll = false)
    {
        $fetch = $this->prepareFetchOneByUserIdAndId($userId, $id, $fields, $visibilityAll);
        $this->clientApi->send($fetch);
        return $this->fetchOne($fetch);
    }

    /**
     * @param string $userId
     * @param string $id
     * @param array $fields
     * @param bool $visibilityAll
     * @return PostsFetch
     */
    protected function prepareFetchOneByUserIdAndId($userId, $id, array $fields, $visibilityAll = false)
    {
        $query = $this->getPostsQuery($fields, array(
            new Single('user_id', $userId),
            new Single('id', $id)
        ));
        if ($visibilityAll) {
            $query->addFilter(new Single('visibility', 'all'));
        }
        return $this->getPostsFetch($query);
    }

    /**
     * @param string $url
     * @param array $fields
     * @param string|null $contextUserId
     * @return Post
     */
    public function fetchOneByUrl($url, array $fields, $contextUserId = null)
    {
        $fetch = $this->prepareFetchOneByUrl($url, $fields, $contextUserId);
        $this->clientApi->send($fetch);
        return $this->fetchOne($fetch);
    }

    /**
     * @param string $url
     * @param array $fields
     * @param string|null $contextUserId
     * @return PostsFetch
     */
    protected function prepareFetchOneByUrl($url, array $fields, $contextUserId = null)
    {
        $query = $this->getPostsQuery($fields, array(new Single('url', $url)));
        $query->setContextUserId($contextUserId);
        return $this->getPostsFetch($query);
    }

    /**
     * @param string $externalId
     * @param array $fields
     * @param bool $visibilityAll
     * @return Post
     * @throws FatalResponseException
     */
    public function fetchOneByExternalId($externalId, array $fields, $visibilityAll = false)
    {
        $fetch = $this->prepareFetchOneByExternalId($externalId, $fields, $visibilityAll);
        $this->clientApi->send($fetch);
        return $this->fetchOne($fetch);
    }

    /**
     * @param string $externalId
     * @param array $fields
     * @param bool $visibilityAll
     * @return PostsFetch
     */
    protected function prepareFetchOneByExternalId($externalId, array $fields, $visibilityAll = false)
    {
        $query = $this->getPostsQuery($fields, array(new Single('external_id', $externalId)));

        if ($visibilityAll) {
            $query->addFilter(new Single('visibility', 'all'));
        }

        return $this->getPostsFetch($query);
    }

    /**
     * @param string $postDate
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @return Posts
     */
    public function fetchLteDatePosts($postDate, array $fields, $limit = null, $offset = null)
    {
        $fetch = $this->prepareFetchLteDatePosts($postDate, $fields, $limit, $offset);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $postDate
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @return PostsFetch
     */
    protected function prepareFetchLteDatePosts($postDate, array $fields, $limit = null, $offset = null)
    {
        $sort = new Sort();
        $sort->setField('post_date');
        $sort->setOrder('desc');

        $filters = array(new SingleWithOperator('post_date', 'lte', $postDate));

        $query = $this->getPostsQuery($fields, $filters, $limit, $offset, $sort);
        return $this->getPostsFetch($query);
    }

    /**
     * @param string $userId
     * @param array $fields
     * @param int $limit
     * @param int $offset
     * @param Sort $sort
     * @param string|null $contextUserId
     * @return Posts
     */
    public function fetchByUserId($userId, array $fields, $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $filters = array(new Single('user_id', $userId));
        $query = $this->getPostsQuery($fields, $filters, $limit, $offset, $sort);
        $query->setContextUserId($contextUserId);
        $fetch = $this->getPostsFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $userId
     * @param array $fields
     * @param int $limit
     * @param int $offset
     * @param Sort $sort
     * @return Posts
     */
    public function fetchDraftsByUserId($userId, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('user_id', $userId),
            new Single('visibility', 'false'),
        );
        $query = $this->getPostsQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getPostsFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $userId
     * @param string $categoryUrl
     * @param array $fields
     * @param int $limit
     * @param int $offset
     * @param Sort $sort
     * @return Posts
     */
    public function fetchByUserIdAndCategoryUrl($userId, $categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('user_id', $userId),
            new Single('category_url', $categoryUrl)
        );
        $query = $this->getPostsQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getPostsFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $categoryUrl
     * @param array $fields
     * @param int $limit
     * @param int $offset
     * @param Sort $sort
     * @param string|null $contextUserId
     * @return Posts
     */
    public function fetchByCategoryUrl($categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $fetch = $this->prepareFetchByCategoryUrl($categoryUrl, $fields, $limit, $offset, $sort, $contextUserId);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $categoryUrl
     * @param array $fields
     * @param int $limit
     * @param int $offset
     * @param Sort $sort
     * @param string|null $contextUserId
     * @return PostsFetch
     */
    protected function prepareFetchByCategoryUrl($categoryUrl, array $fields, $limit = null, $offset = null, Sort $sort = null, $contextUserId = null)
    {
        $filters = array(new Single('category_url', $categoryUrl));
        $query = $this->getPostsQuery($fields, $filters, $limit, $offset, $sort);
        $query->setContextUserId($contextUserId);
        return $this->getPostsFetch($query);
    }

    /**
     * @param Post $post
     * @param string|null $forceUserId
     * @return int
     * @throws UnprocessableEntityException
     */
    public function insertPost(Post $post, $forceUserId = null)
    {
        $query = new PostsQuery($this->apiBaseUrl);
        $query->setMethod('POST');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $query->setContextUserId($forceUserId);

        $postEditBodyConverter = new PostEditBodyConverter();
        $query->setBody(json_encode($postEditBodyConverter->convert($post)));

        if ($post->getId()) {
            throw new UnprocessableEntityException('Insert post with set id not allowed');
        }

        $fetch = new PostEditFetch($query, new NullCache());
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param Post $post
     * @param string|null $forceUserId
     * @return int
     * @throws UnprocessableEntityException
     */
    public function updatePost(Post $post, $forceUserId = null)
    {
        $query = new PostsQuery($this->apiBaseUrl);
        $query->setMethod('PATCH');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $query->setContextUserId($forceUserId);

        $postEditBodyConverter = new PostEditBodyConverter();
        $query->setBody(json_encode($postEditBodyConverter->convert($post, true)));

        if (!$post->getId()) {
            throw new UnprocessableEntityException('Unknown post id for update');
        }
        $query->setPostId($post->getId());

        $fetch = new PostEditFetch($query, new NullCache());
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param $phrase
     * @param null $categoryUrl
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Posts
     */
    public function search($phrase, $categoryUrl = null, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('search', $phrase)
        );

        if ($categoryUrl) {
            $filters[] = new Single('category_url', $categoryUrl);
        }

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }

    /**
     * @param array $ids
     * @param array $fields
     * @param string|null $contextUserId
     * @return Posts
     */
    public function fetchByIds(array $ids, array $fields, $contextUserId = null)
    {
        $filters = array(
            new Single('id', implode(',', $ids))
        );

        return $this->fetchAll($fields, $filters, count($ids), null, null, $contextUserId);
    }
}