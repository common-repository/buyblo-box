<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\Cache\NullCache;
use Nokaut\BuybloApiKit\ClientApi\Rest\Exception\FatalResponseException;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\UserEditFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\UsersFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\SingleWithOperator;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\TokenUserQuery;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\UsersQuery;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Collection\Users;
use Nokaut\BuybloApiKit\Converter\ConverterInterface;
use Nokaut\BuybloApiKit\Converter\UserDeleteBodyConverter;
use Nokaut\BuybloApiKit\Converter\UserDeleteResponseConverter;
use Nokaut\BuybloApiKit\Converter\UserEditBodyConverter;
use Nokaut\BuybloApiKit\Converter\UserTokenConverter;
use Nokaut\BuybloApiKit\Entity\User;

class UsersRepository extends RepositoryAbstract
{
    /**
     * @var array
     */
    public static $fieldsAll = array(
        'id',
        'pid',
        'region',
        'slug',
        'title',
        'description',
        'url',
        'logo_url',
        'logo_template',
        'external_logo_url',
        'logo_original_width',
        'logo_original_height',
        'facebook_url',
        'instagram_url',
        'first_name',
        'last_name',
        'website_platform',
        'recommendation_code',
//        'posts_count',
//        'subscription_id',
        'external_visibility_at'
    );

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return UsersQuery
     */
    protected function getUsersQuery(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = new UsersQuery($this->apiBaseUrl);
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
     * @param UsersQuery $query
     * @return UsersFetch
     */
    protected function getUsersFetch(UsersQuery $query)
    {
        return new UsersFetch($query, $this->cache);
    }

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Users
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getUsersQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getUsersFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param int $count
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Users
     */
    public function fetchByPostsCountGT($count, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new SingleWithOperator('posts_count', 'gt', $count)
        );

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }

    public function insertUser(User $user, $setVisible = false)
    {
        $query = new UsersQuery($this->apiBaseUrl);
        $query->setMethod('POST');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $userEditBodyConverter = new UserEditBodyConverter();
        $query->setBody($userEditBodyConverter->convert($user, false, $setVisible));

        $fetch = new UserEditFetch($query, new NullCache());
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    public function updateUser(User $user)
    {
        $query = new UsersQuery($this->apiBaseUrl);
        $query->setMethod('PATCH');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $query->setUserId($user->getId());
        $userEditBodyConverter = new UserEditBodyConverter();
        $query->setBody($userEditBodyConverter->convert($user, true));

        $fetch = new UserEditFetch($query, new NullCache());
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    public function updateInvisibleUser(User $user, $setVisible = false)
    {
        $query = new UsersQuery($this->apiBaseUrl);
        $query->setMethod('PATCH');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $query->setUserId($user->getId());
        $userEditBodyConverter = new UserEditBodyConverter();
        $query->setBody($userEditBodyConverter->convert($user, false, $setVisible));

        $fetch = new UserEditFetch($query, new NullCache());
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $slug
     * @param array $fields
     * @param string|null $contextUserId
     * @return User
     */
    public function fetchOneBySlug($slug, array $fields, $contextUserId = null)
    {
        $fetch = $this->prepareFetchOneBySlug($slug, $fields, $contextUserId);
        $this->clientApi->send($fetch);
        return $this->fetchOne($fetch);
    }

    /**
     * @param string $userId
     * @param array $fields
     * @param bool $showAll
     * @return User
     */
    public function fetchOneById($userId, array $fields, $showAll = false)
    {
        $fetch = $this->prepareFetchOneById($userId, $fields, $showAll);
        $this->clientApi->send($fetch);
        return $this->fetchOne($fetch);
    }

    /**
     * @param $userId
     * @return string
     */
    public function fetchToken($userId)
    {
        $query = new TokenUserQuery($this->apiBaseUrl);
        $query->setUserId($userId);
        $query->setMethod('POST');

        $fetch = new Fetch($query, new UserTokenConverter(), $this->cache);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param string $slug
     * @param array $fields
     * @param string|null $contextUserId
     * @return UsersFetch
     */
    protected function prepareFetchOneBySlug($slug, array $fields, $contextUserId = null)
    {
        $query = $this->getUsersQuery($fields, array(new Single('slug', $slug)));
        $query->setContextUserId($contextUserId);
        return $this->getUsersFetch($query);
    }

    /**
     * @param string $userId
     * @param array $fields
     * @param bool $showAll
     * @return UsersFetch
     */
    protected function prepareFetchOneById($userId, array $fields, $showAll = false)
    {
        $params = array(new Single('id', $userId));
        if ($showAll) {
            $params[] = new Single('visibility', 'all');
        }
        $query = $this->getUsersQuery($fields, $params);
        return $this->getUsersFetch($query);
    }

    /**
     * @param int $phrase
     * @param array $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Users
     */
    public function search($phrase, array $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('search', $phrase)
        );

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }

    /**
     * @param array $ids
     * @param array $fields
     * @return Users
     */
    public function fetchByIds(array $ids, array $fields)
    {
        $filters = array(
            new Single('id', implode(',', $ids))
        );

        return $this->fetchAll($fields, $filters, count($ids));
    }

    public function deleteUser($userId)
    {
        $query = new UsersQuery($this->apiBaseUrl);
        $query->setMethod('DELETE');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $query->setUserId($userId);

        $body['user_id'] = $userId;
        $query->setBody(json_encode($body));

        $fetch = new Fetch(
            $query,
            new UserDeleteResponseConverter(),
            new NullCache());
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }
}