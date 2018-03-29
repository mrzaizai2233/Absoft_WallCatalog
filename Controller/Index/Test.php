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
        \Magento\Framework\Api\Data\ImageContentInterface $imageContent

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
        return parent::__construct($context);
    }

    public function execute()
    {
        $base64= "";

        $image_data = explode(',',$base64)[1];
        $image_info = finfo_buffer(finfo_open(),base64_decode($image_data),FILEINFO_MIME_TYPE);

        $image_type =  explode('/',$image_info)[1];




        $output_file = 'test123.'.$image_type;
        $this->mediaDirectoryWrite->writeFile($output_file,base64_decode($image_data));

        die;

        return $this->_pageFactory->create();
    }
}