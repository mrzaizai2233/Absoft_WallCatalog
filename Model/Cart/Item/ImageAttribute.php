<?php
namespace Absoft\WallCatalog\Model\Cart\Item;

class ImageAttribute implements \Absoft\WallCatalog\Api\Data\ImageAttributeInterface {

    public function getImage()
    {
        return $this->getData(self::IMAGE);
        // TODO: Implement getImage() method.
    }

    public function setImage($image)
    {
        return $this->setData(self::IMAGE,$image);
        // TODO: Implement setImage() method.
    }
}