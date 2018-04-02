<?php
namespace Absoft\WallCatalog\Controller\Index;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Model\Session as CatalogSession;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

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
    protected $_http;

    protected $mediaDirectoryWrite;

    protected $imageContent;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        CartManagementInterface $cartManagement,
        CartRepositoryInterface $cartRepository,
        CatalogSession $catalogSession,
        CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        \Absoft\WallCatalog\Helper\Data $wallcatalogHelper,
        \Magento\Framework\App\Request\Http $http,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Api\Data\ImageContentInterface $imageContent,
         \Magento\Framework\App\Request\Http $request
        , \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
        , \Magento\Store\Model\StoreManagerInterface $storeManager

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
        $this->_http = $http;
        $this->mediaDirectoryWrite = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->imageContent = $imageContent;

        $this->_request = $request;
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
        return parent::__construct($context);
    }

    public function execute()
    {
        $store = $this->_storeManager->getStore()->getId();
        $transport = $this->_transportBuilder->setTemplateIdentifier('modulename_test_template')
            ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
            ->setTemplateVars(
                [
                    'store' => $this->_storeManager->getStore(),
                ]
            )
            ->setFrom('general')
            // you can config general email address in Store -> Configuration -> General -> Store Email Addresses
            ->addTo('kiepsongthuapc@email.com', 'Customer Name')
            ->getTransport();
        $transport->sendMessage();
        return $this;
    }
}