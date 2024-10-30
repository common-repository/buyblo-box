<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\ClientApi\Rest\Exception\FatalResponseException;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\GroupsFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\GroupsQuery;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Collection\Groups;
use Nokaut\BuybloApiKit\Entity\Group;

class GroupsRepository extends RepositoryAbstract
{
    /**
     * @var array
     */
    public static $fieldsAll = array(
        'category.id',
        'category.title',
        'category.url',
        'products.id',
        'products.type',
        'posts.id',
        'posts.external_id',
        'posts.url',
        'posts.title',
        'posts.excerpt',
        'posts.excerpt_short',
        'posts.content',
        'posts.post_date',
        'posts.photo.url',
        'posts.photo.template',
        'posts.user.id',
        'posts.user.pid',
        'posts.user.region',
        'posts.user.slug',
        'posts.user.title',
        'posts.user.description',
        'posts.user.url',
        'posts.user.logo_url',
        'posts.user.logo_template',
        'posts.user.facebook_url',
        'posts.user.instagram_url',
        'posts.groups.category.id',
        'posts.groups.category.title',
        'posts.groups.category.url',
    );

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return GroupsQuery
     */
    protected function getGroupsQuery(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = new GroupsQuery($this->apiBaseUrl);
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
     * @param GroupsQuery $query
     * @return GroupsFetch
     */
    protected function getGroupsFetch(GroupsQuery $query)
    {
        return new GroupsFetch($query, $this->cache);
    }

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Groups
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getGroupsQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getGroupsFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $productUrl
     * @param string $postId
     * @param array $fields
     * @param string|null $contextUserId
     * @return Group
     */
    public function fetchOneByProductUrlAndPostId($productUrl, $postId, array $fields, $contextUserId = null)
    {
        $filters = array(new Single('product_url', $productUrl));
        $query = $this->getGroupsQuery($fields, $filters);
        if ($postId) {
            $query->addFilter(new Single('post_id', $postId));
        }
        $query->setContextUserId($contextUserId);

        $fetch = $this->getGroupsFetch($query);
        $this->clientApi->send($fetch);
        return $this->fetchOne($fetch);
    }

    /**
     * @param array $idsGroups
     * @param array $fields
     * @return Groups
     */
    public function fetchByGroups(array $idsGroups, array $fields)
    {
        $filters = array(new \Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Groups($idsGroups));
        $query = $this->getGroupsQuery($fields, $filters);
        $fetch = $this->getGroupsFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }
}