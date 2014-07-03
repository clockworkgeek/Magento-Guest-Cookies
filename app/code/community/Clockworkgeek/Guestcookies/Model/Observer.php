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

class Clockworkgeek_Guestcookies_Model_Observer
{

	/**
	 * Try to read cookie's value before cart is manipulated.
	 */
	public function readCartCookie()
	{
		if (Mage::helper('customer')->isLoggedIn()) {
			// registered users are of no interest.
			return;
		}
		/* @var $checkoutSession Mage_Checkout_Model_Session */
		$checkoutSession = Mage::getSingleton('checkout/session');
		if ($checkoutSession->getQuoteId()) {
			// cart already in use, do not override
			return;
		}
		$quote = Mage::getSingleton('guestcookies/quote')->readCookie();
		if ($quote->getId()) {
			$checkoutSession->setQuoteId($quote->getId());
			// preserve addresses and payments
			$checkoutSession->resetCheckout();
		}
	}

	/**
	 * Write cookie to HTTP header at last possible event.
	 */
	public function writeCartCookie()
	{
		if (Mage::helper('guestcookies')->isCookieRestricted()) return;

		if (!Mage::helper('customer')->isLoggedIn()) {
			$quote = $this->getQuote();
			if (!$quote->isObjectNew()) {
				$quote->writeCookie();
			}
			else {
				// cart must be empty
				$quote->removeCookie();
			}
		}
		else {
			Mage::getModel('guestcookies/quote')->removeCookie();
		}
	}

	/**
	 * @return Clockworkgeek_Guestcookies_Model_Quote
	 */
	protected function getQuote()
	{
		$quote = Mage::getSingleton('guestcookies/quote');
		$quoteId = Mage::getSingleton('checkout/session')->getQuoteId();
		if ($quoteId && $quote->isObjectNew()) {
			$quote->load($quoteId);
			// if nothing to load...
			if ($quote->isObjectNew()) {
				// ...create a new one
				$quote->setId($quoteId)
					->save();
			}
		}
		return $quote;
	}

	/**
	 * Read regardless of admin setting.
	 */
	public function readViewedCookie()
	{
		if (!Mage::helper('customer')->isLoggedIn()) {
			Mage::getModel('guestcookies/viewed')->readCookie();
		}
	}

	/**
	 * Respect user's cookie choice.
	 */
	public function writeViewedCookie()
	{
		if (Mage::helper('guestcookies')->isCookieRestricted()) return;

		if (!Mage::helper('customer')->isLoggedIn()) {
			Mage::getSingleton('guestcookies/viewed')->writeCookie();
		}
	}

	/**
	 * Read regardless of admin setting.
	 */
	public function readCompareCookie()
	{
		if (!Mage::helper('customer')->isLoggedIn()) {
			Mage::getModel('guestcookies/compare')->readCookie();
		}
	}

	/**
	 * Respect user's cookie choice.
	 */
	public function writeCompareCookie()
	{
		if (Mage::helper('guestcookies')->isCookieRestricted()) return;

		if (!Mage::helper('customer')->isLoggedIn()) {
			Mage::getSingleton('guestcookies/compare')->writeCookie();
		}
	}

}
