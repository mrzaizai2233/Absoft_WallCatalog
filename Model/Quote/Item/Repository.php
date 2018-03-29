<?php
namespace Absoft\WallCatalog\Model\Quote\Item;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class Repository {

    protected $_logger;

    protected $helperData;


    /**
     * @var \Magento\Framework\Filesystem\Directory\Write
     */
    protected $mediaDirectoryWrite;

    protected $_cartReponsitory;
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Absoft\WallCatalog\Helper\Data $helperData,
        CartRepositoryInterface $cartRepository,
        \Magento\Framework\Filesystem $filesystem

    )
    {
        $this->helperData = $helperData;
        $this->_logger = $logger;
        $this->_cartReponsitory = $cartRepository;
        $this->mediaDirectoryWrite = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);

    }
    /**
     * @param \Magento\Quote\Model\Quote\Item\Repository $subject
     * @param \Magento\Quote\Api\Data\CartItemInterface $cartItem
     * @return mixed
     */
    public function afterSave(\Magento\Quote\Model\Quote\Item\Repository $subject,$cartItem)
    {
        $width_text = $this->helperData->getGeneralConfig('width_sku');
        $height_text = $this->helperData->getGeneralConfig('height_sku');
        $_customOptions = $cartItem->getProduct()->getTypeInstance(true)->getOrderOptions($cartItem->getProduct());
        /**
         * @var \Magento\Catalog\Model\Product $product
         */
        $product = $cartItem->getProduct();
        $price = $product->getPrice();
        $optionProducts = $product->getOptions()?$product->getOptions():[];
        $cm2=1;
        $optionPrice=0;
        foreach($_customOptions['info_buyRequest']['options'] as $index => $value){
            if($index=='image_preview'){

                $image_data = explode(',',$value)[1];
                echo $image_data;
                $image_info = finfo_buffer(finfo_open(),base64_decode($image_data),FILEINFO_MIME_TYPE);
                $image_type =  explode('/',$image_info)[1];
                $output_file = $cartItem->getQuoteId().'_'.$cartItem->getItemId().".jpg";
                $this->mediaDirectoryWrite->writeFile($output_file,base64_decode($image_data));

            }
        }
        foreach ($optionProducts as $optionProduct) {

            $dataOption = $optionProduct->getData();

            if($dataOption['sku']==$width_text || $dataOption['sku']==$height_text) {
                foreach($_customOptions['info_buyRequest']['options'] as $index => $value){
                    if($index==$dataOption['option_id']) {
                        $cm2= $cm2*$value;
                    }
                }
            }

            foreach($_customOptions['info_buyRequest']['options'] as $index => $value){
                if($index==$dataOption['option_id']) {
                    if($dataOption['type']=='field'){
                        $optionPrice+= $dataOption['price'];
                    }
                    if($dataOption['type']=='drop_down'){
                        foreach ($optionProduct->getValues() as $optionValueId => $OptionValues) {
                            if($optionValueId==$value){
                                $optionPrice += $OptionValues->getPrice();
                            }
                        }
                    }
                }
            }
        }
        $total_price = ($cm2*$price)+$optionPrice;
        $cartItem->setCustomPrice($total_price);
        $cartItem->setOriginalCustomPrice($total_price);
        $product->setIsSuperMode(true);

        $cartItem->save();

        $cartId = $cartItem->getQuoteId();
        $quote = $this->_cartReponsitory->get($cartId);

        $quote->collectTotals()->save();
        return $cartItem;

    }

}