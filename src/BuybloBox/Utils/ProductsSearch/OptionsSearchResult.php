<?php

namespace BuybloBox\Utils\ProductsSearch;


class OptionsSearchResult
{
    private $options = array();

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }
}