<?php
/**
 * Image
 *
 * @copyright Copyright © 2018 Absoft. All rights reserved.
 * @author    dattt@absoft.com.vn
 */

namespace Absoft\WallCatalog\Plugin\CheckoutCart;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

class Image
{
    /**
     * @var /Magento\Framework\Filesystem
     */
    protected $fileSystem;


    public function __construct(
        Filesystem $fileSystem
    ) {

        $this->fileSystem = $fileSystem;

    }

    public function afterGetImage(\Magento\Checkout\Block\Cart\Item\Renderer $subject, $result)
    {
        $item = $subject->getItem();

        $itemId = $item->getId();
        $cartId = $item->getQuote()->getId();
        /**
         * @var \Magento\Framework\Filesystem\Directory\ReadInterface $dirMedia
         */
        $dirMedia = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getRelativePath('/pub/media'.'/'.$cartId.'_'.$itemId.'.jpg');
        if(fileExists($dirMedia)){
            $result->setImageUrl($dirMedia);
        }
        return $result;
    }

}