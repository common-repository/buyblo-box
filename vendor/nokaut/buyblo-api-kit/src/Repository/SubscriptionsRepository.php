<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\Cache\NullCache;
use Nokaut\BuybloApiKit\ClientApi\Rest\Exception\UnprocessableEntityException;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\SubscriptionEditFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\SubscriptionsFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\SubscriptionsQuery;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Collection\Subscriptions;
use Nokaut\BuybloApiKit\Entity\Subscription;

class SubscriptionsRepository extends RepositoryAbstract
{
    /**
     * @var array
     */
    public static $fieldsAll = array(
        'id',
        'user_id',
        'resource_id',
        'resource_type',
        'created_at',
        'metadata.total',
    );

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return SubscriptionsQuery
     */
    protected function getSubscriptionsQuery(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = new SubscriptionsQuery($this->apiBaseUrl);
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
     * @param SubscriptionsQuery $query
     * @return SubscriptionsFetch
     */
    protected function getSubscriptionsFetch(SubscriptionsQuery $query)
    {
        return new SubscriptionsFetch($query, $this->cache);
    }

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Subscriptions
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getSubscriptionsQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getSubscriptionsFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param $resourceId
     * @param $resourceType
     * @param $userId
     * @param $fields
     * @return Subscription
     */
    public function fetchSubscription($resourceId, $resourceType, $userId, $fields)
    {
        $filters = array(
            new Single('resource_id', $resourceId),
            new Single('resource_type', $resourceType),
            new Single('user_id', $userId)
        );

        $query = $this->getSubscriptionsQuery($fields, $filters, 1);
        $fetch = $this->getSubscriptionsFetch($query);
        $this->clientApi->send($fetch);
        return $this->fetchOne($fetch);
    }

    /**
     * @param $userId
     * @param $resourceType
     * @param $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Subscriptions
     */
    public function fetchUserSubscriptions($userId, $resourceType, $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('user_id', $userId),
            new Single('resource_type', $resourceType)
        );

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }

    /**
     * @param $resourceId
     * @param $resourceType
     * @param $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Subscriptions
     */
    public function fetchSubscribers($resourceId, $resourceType, $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('resource_id', $resourceId),
            new Single('resource_type', $resourceType)
        );

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }

    /**
     * @param Subscription $subscription
     * @return \Nokaut\BuybloApiKit\Collection\CollectionInterface|\Nokaut\BuybloApiKit\Entity\EntityAbstract
     * @throws UnprocessableEntityException
     */
    public function create(Subscription $subscription)
    {
        if ($subscription->getId()) {
            throw new UnprocessableEntityException('Insert subscription with set id not allowed');
        }

        $data = array(
            'subscription' => array(
                'resource_id' => $subscription->getResourceId(),
                'resource_type' => $subscription->getResourceType()
            ),
            'user_id' => $subscription->getUserId()
        );

        $query = new SubscriptionsQuery($this->apiBaseUrl);
        $query->setMethod('POST');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $query->setBody(json_encode($data));

        $fetch = new SubscriptionEditFetch($query, new NullCache());
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param Subscription $subscription
     * @return \Nokaut\BuybloApiKit\Collection\CollectionInterface|\Nokaut\BuybloApiKit\Entity\EntityAbstract
     * @throws UnprocessableEntityException
     */
    public function delete(Subscription $subscription)
    {
        if (!$subscription->getId()) {
            throw new UnprocessableEntityException('Delete subscription without id is not allowed');
        }

        if (!$subscription->getUserId()) {
            throw new UnprocessableEntityException('Delete subscription without user id is not allowed');
        }

        $data = array(
            'user_id' => $subscription->getUserId()
        );

        $query = new SubscriptionsQuery($this->apiBaseUrl);
        $query->setMethod('DELETE');
        $query->setHeaders(array('Content-Type' => 'application/json'));
        $query->setBody(json_encode($data));
        $query->setSubscriptionId($subscription->getId());

        $fetch = new SubscriptionEditFetch($query, new NullCache());
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }
}