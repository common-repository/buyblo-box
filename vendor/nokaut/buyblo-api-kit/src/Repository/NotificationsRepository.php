<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\NotificationsFetch;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\NotificationsQuery;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter\Single;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\Sort;
use Nokaut\BuybloApiKit\Collection\Notifications;
use Nokaut\BuybloApiKit\Entity\Notification;

class NotificationsRepository extends RepositoryAbstract
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
        'subscriptions.id',
        'subscriptions.resource_type',
        'metadata.total',
    );

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return NotificationsQuery
     */
    protected function getNotificationsQuery(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = new NotificationsQuery($this->apiBaseUrl);
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
     * @param NotificationsQuery $query
     * @return NotificationsFetch
     */
    protected function getNotificationsFetch(NotificationsQuery $query)
    {
        return new NotificationsFetch($query, $this->cache);
    }

    /**
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Notifications
     */
    public function fetchAll(array $fields, array $filters = array(), $limit = null, $offset = null, Sort $sort = null)
    {
        $query = $this->getNotificationsQuery($fields, $filters, $limit, $offset, $sort);
        $fetch = $this->getNotificationsFetch($query);
        $this->clientApi->send($fetch);
        return $fetch->getResult();
    }

    /**
     * @param $userId
     * @param $fields
     * @param null $limit
     * @param null $offset
     * @param Sort|null $sort
     * @return Notifications
     */
    public function fetchUserNotifications($userId, $fields, $limit = null, $offset = null, Sort $sort = null)
    {
        $filters = array(
            new Single('user_id', $userId),
        );

        return $this->fetchAll($fields, $filters, $limit, $offset, $sort);
    }
}