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

class Clockworkgeek_Guestcookies_Model_Quote
 extends Clockworkgeek_Guestcookies_Model_Token_Abstract
{

	protected function _construct()
	{
		$this->_init('guestcookies/quote');
	}

	public function getName()
	{
		return Mage::getStoreConfig('web/guestcookies/quote_name');
	}

	public function writeCookie()
	{
		if (Mage::getStoreConfigFlag('web/guestcookies/quote')) {
			parent::writeCookie();
		}
		return $this;
	}

}
