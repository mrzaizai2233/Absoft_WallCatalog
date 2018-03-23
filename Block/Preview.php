<?php
namespace Absoft\WallCatalog\Block;

use Magento\Bundle\Api\ProductOptionRepositoryInterface;
use Magento\Catalog\Api\Data\ProductCustomOptionInterface;
use Magento\Catalog\Api\ProductCustomOptionRepositoryInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Asset\Repository;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;

class Preview extends \Magento\Framework\View\Element\Template {

    protected $_request;
    protected $_assetRepository;
    protected $_cartManager;
    protected $_checkoutSession;
    protected $quoteIdMaskFactory;
    protected $_cartRepository;
    protected $_productRepository;
    protected $_searchCriteria;
    protected $_searchCriteriaBuilder;
    protected $_filterBuilder;
    protected $_filterBUilderGroup;
    protected $_productCustomOptionRepository;
    protected $_productCustomOption;
    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        Repository $assetRepository,
        CartManagementInterface $cartManagement,
        CheckoutSession $checkoutSession,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        CartRepositoryInterface $cartRepository,
        ProductRepository $productRepository,
        SearchCriteria $searchCriteria,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        ProductCustomOptionRepositoryInterface $productCustomOptionRepository

    )
    {
        $this->_request = $request;
        $this->_assetRepository = $assetRepository;
        $this->_cartManager = $cartManagement;
        $this->_checkoutSession = $checkoutSession;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->_cartRepository = $cartRepository;
        $this->_productRepository = $productRepository;
        $this->_searchCriteria = $searchCriteria;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_filterBuilder = $filterBuilder;
        $this->_filterBUilderGroup = $filterGroupBuilder;
        $this->_productCustomOptionRepository =$productCustomOptionRepository;
        parent::__construct($context);
    }

    public function getSku(){
        return $this->getRequest()->getParam('sku');
    }

    /**
     * @return array
     */
    public function getParams(){
        return $this->getRequest()->getParams();
    }

    public function getParam($key){
        return $this->getRequest()->getParam($key);
    }
    public function getDirImages(){

    }

    public function getCart(){

    }

    public function getProduct(){
        $product_sku = $this->getRequest()->getParam('sku');

        return $this->_productRepository->get($product_sku);


    }

    /**
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getProductByAttributeSet(){
        $searchCriteria = $this->_searchCriteriaBuilder->addFilter('is_customizable','1')->create();
        return $this->_productRepository->getList($searchCriteria);
    }

    /**
     * @param $product
     * @return \Magento\Catalog\Api\Data\ProductCustomOptionInterface[]
     */
    public function getProductOptions($product){
        return $this->_productCustomOptionRepository->getProductOptions($product);
    }

    /**
     * @param $sku
     * @return \Magento\Catalog\Api\Data\ProductCustomOptionInterface[]
     */
    public function getOptions($sku){

        $product= $this->_productRepository->get($sku);
        return $this->_productCustomOptionRepository->getProductOptions($product);
    }

    public function getQuoteIdMask(){


        $quoteID=null;
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