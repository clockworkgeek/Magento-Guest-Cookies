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

class Clockworkgeek_Guestcookies_Model_System_Source_Lifetimes
{

	public function toOptionArray()
	{
		$helper = Mage::helper('guestcookies');
		return array(
			array('value' => 3600, 'label' => $helper->__('1 Hour')),
			array('value' => 86400, 'label' => $helper->__('1 Day')),
			array('value' => 604800, 'label' => $helper->__('1 Week')),
			array('value' => 2592000, 'label' => $helper->__('1 Month')),
			array('value' => 31557600, 'label' => $helper->__('1 Year')),
			array('value' => 315576000, 'label' => $helper->__('10 Years')),
			array('value' => 788940000, 'label' => $helper->__('25 Years')),
		);
	}

}
