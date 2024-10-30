<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 13.04.2017
 * Time: 10:45
 */

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\User;

class UserEditResponseConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return User
     */
    public function convert(\stdClass $object)
    {
        if (isset($object->user)) {
            if (isset($object->user->id)) {
                return $object->user->id;
            }
        }
        return null;
    }
}