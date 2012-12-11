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

abstract class Clockworkgeek_Guestcookies_Model_Token_Abstract
 extends Clockworkgeek_Guestcookies_Model_Cookie_Abstract
{

	/**
	 * Name of DB field for storing public use token values
	 * 
	 * @var string
	 */
	protected $_tokenField = 'token';

	/**
	 * Expected length of token values in characters
	 * 
	 * @var int
	 */
	protected $_tokenLength = 32;

	/**
	 * @see Mage_Core_Model_Abstract::_beforeSave
	 * @return Clockworkgeek_Guestcookies_Model_Token_Abstract $this
	 */
	protected function _beforeSave()
	{
		parent::_beforeSave();
		$this->getToken();
		return $this;
	}

	/**
	 * Guarantees a secure, random value using only printable characters.
	 * 
	 * @return string
	 */
	public function getToken()
	{
		if (!$this->hasData($this->_tokenField)) {
			$this->setData($this->_tokenField, $this->generateToken());
		}
		return $this->getData($this->_tokenField);
	}

	/**
	 * Generate a random value suitable for public use.
	 * 
	 * @param int $length Should be a product of 4.
	 * @return string
	 */
	public function generateToken($length = null)
	{
		$length = $length ? $length : $this->_tokenLength;
		// replace '+' because it doesn't URL encode neatly
		return strtr(base64_encode(openssl_random_pseudo_bytes($length * 0.75)),
			'+/', '..');
	}

	public function readCookie()
	{
		return $this->load($this->_readCookie(), $this->_tokenField);
	}

	public function writeCookie()
	{
		$this->_updateCookie($this->getToken());
		return $this;
	}

}
