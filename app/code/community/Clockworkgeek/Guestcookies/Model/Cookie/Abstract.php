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

/**
 * Base class for cookie values.
 * 
 * Descendents must set a name and override readCookie() and writeCookie()
 * 
 * @method string getName()
 */
abstract class Clockworkgeek_Guestcookies_Model_Cookie_Abstract
 extends Mage_Core_Model_Abstract
{

	/**
	 * Perform whatever action is necessary to use cookie data.
	 * 
	 * @see getName()
	 * @return Clockworkgeek_Guestcookies_Model_Cookie_Abstract $this
	 */
	public abstract function readCookie();

	/**
	 * Update cookie with latest data.
	 * 
	 * @see getName()
	 * @return Clockworkgeek_Guestcookies_Model_Cookie_Abstract $this
	 */
	public abstract function writeCookie();

	/**
	 * Does what it says on the tin.
	 * 
	 * @see getName()
	 * @return Clockworkgeek_Guestcookies_Model_Cookie_Abstract
	 */
	public function removeCookie()
	{
		$cookie = Mage::getSingleton('core/cookie');
		if ($cookie->get($this->getName())) {
			$cookie->delete($this->getName());
		}
		return $this;
	}

	/**
	 * @return Mage_Core_Model_cookie
	 */
	protected function _getCookie()
	{
		static $cookie;
		if (!$cookie) {
			$cookie = Mage::getSingleton('core/cookie');
		}
		return $cookie;
	}

	/**
	 * Reads the raw value of this cookie
	 * 
	 * @return string|null
	 */
	protected function _readCookie()
	{
		return $this->_getCookie()->get($this->getName());
	}

	/**
	 * Set a far future cookie only if it is different.
	 * 
	 * @param string $value
	 */
	protected function _updateCookie($value)
	{
		if (Mage::helper('guestcookies')->isCookieRestricted()) {
			return;
		}
		if ($this->_getCookie()->get($this->getName()) !== $value) {
			if (isset($value)) {
				$this->_getCookie()->set($this->getName(), $value,
					Mage::getStoreConfig('web/guestcookies/cookie_lifetime'));
			}
			else {
				$this->_getCookie()->delete($this->_getName());
			}
		}
	}

}
