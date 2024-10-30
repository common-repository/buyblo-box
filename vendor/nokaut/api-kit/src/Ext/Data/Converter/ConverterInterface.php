<?php

namespace Nokaut\ApiKitBB\Ext\Data\Converter;

use Nokaut\ApiKitBB\Collection\Products;

interface ConverterInterface
{
    /**
     * @param Products $products
     * @param array $callbacks
     * @return mixed
     */
    public function convert(Products $products, $callbacks = array());
} 