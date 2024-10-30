<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Collection\Users;

class UsersConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Users
     */
    public function convert(\stdClass $object)
    {
        $userConverter = new UserConverter();
        $entities = array();
        foreach ($object->users as $userObject) {
            $entities[] = $userConverter->convert($userObject);
        }

        $users = new Users($entities);
        return $users;
    }
}