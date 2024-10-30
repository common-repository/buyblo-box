<?php

namespace Nokaut\BuybloApiKit\Entity;


abstract class EntityAbstract
{
    public function set($fieldName, $value)
    {
        if (!property_exists($this, $fieldName)) {
            return;
        }
        $this->$fieldName = $value;
    }

    public function get($fieldName)
    {
        if (!property_exists($this, $fieldName)) {
            trigger_error('field ' . $fieldName . ' not defined', E_USER_NOTICE);
            return null;
        }
        return $this->$fieldName;
    }
} 