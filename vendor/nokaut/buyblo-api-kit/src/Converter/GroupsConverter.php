<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Collection\Groups;

class GroupsConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Groups
     */
    public function convert(\stdClass $object)
    {
        $groupConverter = new GroupConverter();
        $entities = array();
        foreach ($object->groups as $groupObject) {
            $entities[] = $groupConverter->convert($groupObject);
        }

        $groups = new Groups($entities);
        return $groups;
    }
}