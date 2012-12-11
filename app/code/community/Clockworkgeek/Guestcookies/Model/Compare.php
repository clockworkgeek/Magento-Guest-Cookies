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

class Clockworkgeek_Guestcookies_Model_Compare
 extends Clockworkgeek_Guestcookies_Model_Cookie_Abstract
{

	protected function _construct()
	{
		$this->setName(Mage::getStoreConfig('web/guestcookies/compare_name'));
	}

	/**
	 * List comparable products from database for this visitor
	 * 
	 * @return array
	 */
	public function getProductIds()
	{
		/* @var $items Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Compare_Item_Collection */
		$items = Mage::helper('catalog/product_compare')->getItemCollection();
		return $items->getColumnValues('product_id');
	}

	public function readCookie()
	{
		if (Mage::helper('catalog/product_compare')->getItemCount()) {
			// visitor already has comparisons
			return $this;
		}

		$productIds = explode(' ', $this->_readCookie());
		$productIds = array_filter($productIds, 'is_numeric');
		// only calculate if there is data to work with
		if ($productIds) {
			Mage::getSingleton('catalog/product_compare_list')
					->addProducts($productIds);
			Mage::helper('catalog/product_compare')->calculate();
		}

		return $this;
	}

	public function writeCookie()
	{
		if (Mage::getStoreConfigFlag('web/guestcookies/compare')) {
			$this->_updateCookie(implode(' ', $this->getProductIds()));
		}

		return $this;
	}

}

