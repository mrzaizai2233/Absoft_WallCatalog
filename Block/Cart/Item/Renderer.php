<?php
/**
 * Renderer
 *
 * @copyright Copyright © 2018 Absoft. All rights reserved.
 * @author    dattt@absoft.com.vn
 */

namespace Absoft\WallCatalog\Block\Cart\Item;


use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Message\InterpretationStrategyInterface;

class Renderer extends \Magento\Checkout\Block\Cart\Item\Renderer
{
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                \Magento\Catalog\Helper\Product\Configuration $productConfig,
                                \Magento\Checkout\Model\Session $checkoutSession,
                                \Magento\Catalog\Block\Product\ImageBuilder $imageBuilder,
                                \Magento\Framework\Url\Helper\Data $urlHelper,
                                \Magento\Framework\Message\ManagerInterface $messageManager,
                                PriceCurrencyInterface $priceCurrency,
                                \Magento\Framework\Module\Manager $moduleManager,
                                InterpretationStrategyInterface $messageInterpretationStrategy,
                                Filesystem $filesystem,
                                array $data = [])
    {
        $this->fileSystem = $filesystem;

        parent::__construct($context, $productConfig, $checkoutSession, $imageBuilder, $urlHelper, $messageManager, $priceCurrency, $moduleManager, $messageInterpretationStrategy, $data);
    }

    /**
     * @return null|string
     */
    public function getImagePreview(){

        $product = $this->getProductForThumbnail();

        $base_image = $this->getImage($product,'cart_page_product_thumbnail');

        $item = $this->getItem();

        $itemId = $item->getId();
        $cartId = $item->getQuote()->getId();
        $wallcatalog_media = '/wallcatalog/cart/item/';

        $dirMedia = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getRelativePath('/pub/media'.$wallcatalog_media.$cartId.'_'.$itemId.'.jpg');
        if($this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->isExist($wallcatalog_media.$cartId.'_'.$itemId.'.jpg')){
           return $dirMedia;
        }
        return null;
    }

}