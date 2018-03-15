<?php
namespace Absoft\WallCatalog\Block;

/**
 * AdditionalProInfo
 */
class AdditionalProInfo extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    /**
     * @return additional information data
     */
    public function getAdditionalData()
    {
        // Do your code here
        return "Additional Informations";
    }
}