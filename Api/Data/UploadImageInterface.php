<?php
namespace Absoft\WallCatalog\Api\Data;

interface UploadImageInterface {
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string.
     */
    public function upload($base64);
}
