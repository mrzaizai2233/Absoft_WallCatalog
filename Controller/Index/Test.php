<?php
namespace Absoft\WallCatalog\Controller\Index;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Model\Session as CatalogSession;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;

class Test extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_cartManager;
    protected $_catalogSession;
    protected $_customerSession;
    protected $_checkoutSession;
    protected $_cartRepository;
    protected $quoteIdMaskFactory;
    protected $_wallcatalogHelper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        CartManagementInterface $cartManagement,
        CartRepositoryInterface $cartRepository,
        CatalogSession $catalogSession,
        CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        \Absoft\WallCatalog\Helper\Data $wallcatalogHelper


    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_catalogSession = $catalogSession;
        $this->_checkoutSession = $checkoutSession;
        $this->_customerSession = $customerSession;
        $this->_cartManager = $cartManagement;
        $this->_cartRepository = $cartRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->_wallcatalogHelper = $wallcatalogHelper;
        return parent::__construct($context);
    }

    public function execute()
    {

        $quoteID = $this->_checkoutSession->getQuoteId();
        echo $quoteID;
        $quoteIdMask = $this->quoteIdMaskFactory->create();
        if($quoteID){
            $quoteIdMask->load($quoteID, 'quote_id');
        } else {
            $customerId = $this->_customerSession->getCustomerId();
            if($customerId){
                $quoteID = $this->_cartManager->createEmptyCartForCustomer($customerId);
            } else {
                $quoteID = $this->_cartManager->createEmptyCart();
            }
            $cart = $this->_cartRepository->get($quoteID);
            $this->_checkoutSession->replaceQuote($cart);
            $quoteIdMask->setQuoteId($quoteID)->save();
        }

        echo $quoteIdMask->getQuoteId();
        echo $this->_checkoutSession->getQuoteId();
        die;

        return $this->_pageFactory->create();
    }
}