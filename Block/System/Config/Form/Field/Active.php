<?php

namespace Absoft\WallCatalog\Block\System\Config\Form\Field;

class Active extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray {

    /**
     * Grid columns
     *
     * @var array
     */
    protected $_columns = [];
    protected $_customerGroupRenderer;

    /**
     * Enable the "Add after" button or not
     *
     * @var bool
     */
    protected $_addAfter = true;

    /**
     * Label of add button
     *
     * @var string
     */
    protected $_addButtonLabel;

    /**
     * Check if columns are defined, set template
     *
     * @return void
     */
    protected function _construct() {
        parent::_construct();
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender() {

        $this->addColumn('option_title', array('label' => __('Option Title')));
        $this->addColumn('to_url', array('label' => __('To Url')));
        $this->addColumn('icon', array('label' => __('Icon')));
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    protected function _prepareArrayRow(\Magento\Framework\DataObject $row) {
        $options = [];
        $row->setData('option_extra_attrs', $options);
    }
    /**
     * Render array cell for prototypeJS template
     *
     * @param string $columnName
     * @return string
     * @throws \Exception
     */
    public function renderCellTemplate($columnName)
    {
        if ($columnName == "active") {
            $this->_columns[$columnName]['class'] = 'input-text required-entry validate-number';
            $this->_columns[$columnName]['style'] = 'width:50px';
        }

        return parent::renderCellTemplate($columnName);
    }
}