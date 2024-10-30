<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\User;
use Nokaut\BuybloApiKit\Entity\User\SubscriptionsCounts;

class UserConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return User
     */
    public function convert(\stdClass $object)
    {
        $user = new User();

        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                switch ($field) {
                    case 'subscriptions_counts':
                        $user->setSubscriptionsCounts($this->convertSubscriptionsCounts($value));
                        break;
                }
            } else {
                switch ($field) {
                    case 'external_visibility_at':
                        $user->setExternalVisibilityAt(new \DateTime($value));
                        break;
                    default:
                        $user->set($field, $value);
                        break;
                }
            }
        }

        return $user;
    }

    /**
     * @param $object
     * @return SubscriptionsCounts
     */
    private function convertSubscriptionsCounts($object)
    {
        $count = new SubscriptionsCounts();
        $count->setPost($object->post);
        $count->setUser($object->user);
        $count->setProduct($object->product);
        $count->setCategory($object->category);

        return $count;
    }
}