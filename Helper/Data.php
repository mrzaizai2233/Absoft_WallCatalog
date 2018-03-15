<?php

namespace Absoft\WallCatalog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

	const XML_PATH_HELLOWORLD = 'wall_catalog_config/';

	public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}

	public function getGeneralConfig($code, $storeId = null)
	{

		return $this->getConfigValue(self::XML_PATH_HELLOWORLD .'wall_catalog_settings/'. $code, $storeId);
	}

	public function getOptionSelectConfig($code,$storeId=null){

        return $this->getConfigValue(self::XML_PATH_HELLOWORLD .'custom_option_select/'. $code, $storeId);

    }

    public function getOptionSelectConfig1($code,$storeId=null){

        return $this->getConfigValue(self::XML_PATH_HELLOWORLD .'custom_option_select_1/'. $code, $storeId);

    }

}
