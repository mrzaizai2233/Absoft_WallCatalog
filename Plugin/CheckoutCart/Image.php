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

    /**
     * @param \Magento\Checkout\Block\Cart\Item\Renderer $block
     */
    public function beforeToHtml(\Magento\Checkout\Block\Cart\Item\Renderer $block)
    {
        if($block->getTemplate()=='Magento_Checkout::cart/item/default.phtml'){
            $block->setTemplate('Absoft_WallCatalog::checkout/cart/item/default.phtml');
        }
    }

//    public function afterGetImage(\Magento\Checkout\Block\Cart\Item\Renderer $subject, $result)
//    {
//        $item = $subject->getItem();
//
//        $itemId = $item->getId();
//        $cartId = $item->getQuote()->getId();
//        $wallcatalog_media = '/wallcatalog/cart/item/';
//
//        /**
//         * @var \Magento\Framework\Filesystem\Directory\ReadInterface $dirMedia
//         */
//        $dirMedia = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getRelativePath('/pub/media'.$wallcatalog_media.$cartId.'_'.$itemId.'.jpg');
//        if($this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->isExist($wallcatalog_media.$cartId.'_'.$itemId.'.jpg')){
//            $result->setImageUrl($dirMedia);
//        }
//        return $result;
//    }


    public function afterGetImage(\Magento\Checkout\Block\Cart\Item\Renderer $subject, $result)
    {
        foreach ($subject->getOptionList() as $item) {
            if($item['label']=='Image Preview'){
                return $result->setImageUrl('/pub/media/wallcatalog/cart/'.$item['print_value']);
            }
        }
        return $result;
    }

}