<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.06.2014
 * Time: 08:25
 */

namespace Nokaut\ApiKitBB\Converter;



use Nokaut\ApiKitBB\Converter\Product\PricesConverter;
use Nokaut\ApiKitBB\Converter\Product\PropertyConverter;
use Nokaut\ApiKitBB\Converter\Product\RatingConverter;
use Nokaut\ApiKitBB\Converter\Product\ShopConverter as ProductShopConverter;
use Nokaut\ApiKitBB\Entity\Product;

class ProductConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $product = new Product();

        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObject($product, $field, $value);
            } else {
                $product->set($field, $value);
            }
        }
        $this->sortPhotoIds($product);
        return $product;
    }

    protected function convertSubObject(Product $product, $field, $value)
    {
        switch ($field) {
            case 'properties':
                $product->setProperties($this->convertProperties($value));
                break;
            case 'photo_ids':
                $product->setPhotoIds((array)$value);
                break;
            case 'prices':
                $pricesConverter = new PricesConverter();
                $product->setPrices($pricesConverter->convert($value));
                break;
            case 'shop':
                $shopConverter = new ProductShopConverter();
                $product->setShop($shopConverter->convert($value));
                break;
            case 'rating':
                $ratingConverter = new RatingConverter();
                $product->setRating($ratingConverter->convert($value));
                break;
        }
    }

    protected function convertProperties(array $propertiesFromApi)
    {
        $propertyConverter = new PropertyConverter();
        $propertiesList = array();

        foreach ($propertiesFromApi as $propertyFromApi) {
            $propertiesList[] = $propertyConverter->convert($propertyFromApi);
        }

        return $propertiesList;
    }

    /**
     * @param $product
     */
    protected function sortPhotoIds(Product $product)
    {
        $photoIds = $product->getPhotoIds();
        if($photoIds == null) {
            return;
        }

        foreach($photoIds as $index => $photoId) {
            if($photoId == $product->getPhotoId()) {
                unset($photoIds[$index]);
                break;
            }
        }

        array_unshift($photoIds, $product->getPhotoId());
        $product->setPhotoIds($photoIds);
    }
} 