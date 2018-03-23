<?php
namespace Absoft\WallCatalog\Block\Product;

use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Model\QuoteIdMaskFactory;

class View extends \Magento\Catalog\Block\Product\View {
    protected $_cartManager;
    protected $_customerSession;
    protected $_checkoutSession;
    protected $_cartRepository;
    protected $quoteIdMaskFactory;
    public function __construct(\Magento\Catalog\Block\Product\Context $context,
                                \Magento\Framework\Url\EncoderInterface $urlEncoder,
                                \Magento\Framework\Json\EncoderInterface $jsonEncoder,
                                \Magento\Framework\Stdlib\StringUtils $string,
                                \Magento\Catalog\Helper\Product $productHelper,
                                \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
                                \Magento\Framework\Locale\FormatInterface $localeFormat,
                                \Magento\Customer\Model\Session $customerSession,
                                \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
                                \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
                                CartManagementInterface $cartManagement,
                                CartRepositoryInterface $cartRepository,
                                CheckoutSession $checkoutSession,
                                QuoteIdMaskFactory $quoteIdMaskFactory,
                                array $data = [])
    {
        $this->_checkoutSession = $checkoutSession;

        $this->_cartManager = $cartManagement;

        $this->_cartRepository = $cartRepository;

        $this->quoteIdMaskFactory = $quoteIdMaskFactory;

        $this->_customerSession = $customerSession;
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }

    public function getCartMaskId(){
        $quoteID = $this->_checkoutSession->getQuoteId();
        if(!$quoteID){
            $customerId = $this->_customerSession->getCustomerId();
            if($customerId){
                $quoteID = $this->_cartManager->createEmptyCartForCustomer($customerId);
            } else {
                $quoteID = $this->_cartManager->createEmptyCart();
            }
            $cart = $this->_cartRepository->get($quoteID);
            $this->_checkoutSession->replaceQuote($cart);
        }
        $quoteID = $this->_checkoutSession->getQuoteId();

        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($quoteID, 'quote_id');
        $maskedId = $quoteIdMask->getMaskedId();
        if(!$maskedId){
            $quoteIdMask->setQuoteId($quoteID)->save();
            $maskedId = $quoteIdMask->getMaskedId();
        }
        return $maskedId;
    }

}