<?php
/**
 * Saferpay Ecommerce Magento Payment Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Saferpay Business to
 * newer versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright Copyright (c) 2011 Openstream Internet Solutions (http://www.openstream.ch)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Saferpay_Ecommerce_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getSetting($key)
	{
		return Mage::getStoreConfig('saferpay/settings/' . $key);
	}
	
	/**
	 * Unified round() implementation for the Saferpay extension
	 *
	 * @param mixed $value String, Integer or Float
	 * @return float
	 */
	public function round($value)
	{
		return Zend_Locale_Math::round($value, 2);
	}
	
	public function process_url($url){
        if($this->getSetting('http_client_adapter') == 'Zend_Http_Client_Adapter_Curl' && in_array('curl', get_loaded_extensions())){
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_PORT, 443);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			$ret = curl_exec($ch);
			curl_close($ch);
		}else{
			$ret = file_get_contents($url);
		}
		return $ret;
	}
}