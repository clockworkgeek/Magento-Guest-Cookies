<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * @category   Utilities
 * @package    Clockworkgeek_Guestcookies
 * @author     Daniel Deady <daniel@clockworkgeek.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Clockworkgeek_Guestcookies_Helper_Data extends Mage_Core_Helper_Data
{

	/**
	 * Due to EU law user may request cookies are not applied.
	 * This checks feature if present, which is only in some versions.
	 */
	public function isCookieRestricted()
	{
        $helperClass = Mage::getConfig()->getHelperClassName('core/cookie');
        if (!@class_exists($helperClass)) return false;

		$helper = Mage::helper('core/cookie');
		return $helper->isUserNotAllowSaveCookie();
	}

}
