<?php
namespace Absoft\WallCatalog\Model;
class ImagePreview implements \Absoft\WallCatalog\Api\Data\ImagePreviewInterface {

    /**
     * Return value.
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->getData(self::VALUE);
    }
    /**
     * Set value.
     *
     * @param string|null $value
     * @return $this
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }
}