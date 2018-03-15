<?php

namespace Absoft\WallCatalog\Model\GuestCart;

class GuestCartItemRepository
{


    protected $_logger;
    protected $helperData;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Absoft\WallCatalog\Helper\Data $helperData
    )
    {
        $this->helperData = $helperData;
        $this->_logger = $logger;
    }

    public function afterSave(\Magento\Quote\Model\GuestCart\GuestCartItemRepository $subject,$cartItem)
    {
        $width_text = $this->helperData->getGeneralConfig('width_sku');
        $height_text = $this->helperData->getGeneralConfig('height_sku');
        $_customOptions = $cartItem->getProduct()->getTypeInstance(true)->getOrderOptions($cartItem->getProduct());

        $product = $cartItem->getProduct();
        $price = $product->getPrice();
        $optionProducts = $product->getOptions()?$product->getOptions():[];
        $cm2=1;
        foreach ($optionProducts as $optionProduct) {

            $dataOption = $optionProduct->getData();
            if($dataOption['sku']==$width_text || $dataOption['sku']==$height_text) {
                foreach($_customOptions['info_buyRequest']['options'] as $index => $value){
                        if($index==$dataOption['option_id']) {
                            $cm2= $cm2*$value;
                        }
                }
            }
        }
        $total_price = $cm2*$price;
        $cartItem->setCustomPrice($total_price);
        $cartItem->setOriginalCustomPrice($total_price);
        $cartItem->setPrice($total_price);
        $cartItem->setBasePrice($total_price);
        $cartItem->setBaseRowTotal($total_price);
        $cartItem->setRowTotal($total_price);
        $cartItem->getProduct()->setIsSuperMode(true);


        $cartItem->save();
        return $cartItem;

    }
}