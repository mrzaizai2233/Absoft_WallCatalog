<?php
/**
 * Select
 *
 * @copyright Copyright © 2018 Absoft. All rights reserved.
 * @author    dattt@absoft.com.vn
 */

namespace Absoft\WallCatalog\Block;


class Select
{
    public function beforeToHtml(\Magento\Catalog\Block\Product\View\Options\Type\Select $subject)
    {
            $subject->setTemplate('Absoft_WallCatalog::product/view/options/type/select.phtml');
    }
}