<?php
namespace Absoft\Wallcatalog\Plugin\Minicart;

class Image {

    /**
     * @var \Magento\Catalog\Helper\Product\Configuration
     */
        protected $_productConfig;

        public function __construct(\Magento\Catalog\Helper\Product\Configuration $productConfig)
        {
            $this->_productConfig  = $productConfig;
        }

    /**
     * @param \Magento\Checkout\CustomerData\AbstractItem $subject
     * @param $proceed
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return mixed
     */
        public function aroundGetItemData(\Magento\Checkout\CustomerData\AbstractItem $subject, $proceed, $item)
        {
            /* @var $helper \Magento\Catalog\Helper\Product\Configuration */
            $helper = $this->_productConfig;
            $product = $item->getProduct();

            $result = $proceed($item);
            foreach ($helper->getCustomOptions($item) as $option) {
                if($option['label']=='Image Preview'){
                    $result['product_image']['src']= '/pub/media/wallcatalog/cart/'.$option['print_value'];
                }
            }
            $result['product_url']='#';

            return $result;

        }
}