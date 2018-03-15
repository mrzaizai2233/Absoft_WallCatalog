<?php
namespace Absoft\WallCatalog\Api\Data;

interface ImageAttributeInterface {
    CONST IMAGE='image';

    public function getImage();

    public function setImage($image);
}