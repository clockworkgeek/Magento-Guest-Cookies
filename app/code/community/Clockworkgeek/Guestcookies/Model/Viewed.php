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

class Clockworkgeek_Guestcookies_Model_Viewed
 extends Clockworkgeek_Guestcookies_Model_Cookie_Abstract
{

	protected function _construct()
	{
		$this->setName(Mage::getStoreConfig('web/guestcookies/viewed_name'));
	}

	/**
	 * Update database with this visitor's recently viewed list
	 * 
	 * @param array $ids
	 * @return Clockworkgeek_Guestcookies_Model_Viewed $this
	 */
	public function addProductIds($ids)
	{
		if ($ids) {
			foreach ($ids as $id) {
			    try {
    				Mage::getModel('reports/product_index_viewed')
    					->setProductId($id)
    					->save();
			    }
			    catch (Exception $e) {
			        // do nothing if product ID is missing
			    }
			}
			Mage::getModel('reports/product_index_viewed')
				->calculate();
		}
		return $this;
	}

	/**
	 * List recently viewed products from database for this visitor
	 * 
	 * @return array
	 */
	public function getProductIds()
	{
		$viewed = Mage::getResourceModel('reports/product_index_viewed_collection');
		$viewed->addIndexFilter();
		return $viewed->getColumnValues('product_id');
	}

	/**
	 * Number of recently viewed products.
	 */
	public function getProductsCount()
	{
		return Mage::getModel('reports/product_index_viewed')->getCount();
	}

	public function readCookie()
	{
		if ($this->getProductsCount()) {
			// do not mix existing list with new data
			return $this;
		}

		$newProductIds = explode(' ', $this->_readCookie());
		$newProductIds = array_filter($newProductIds, 'is_numeric');
		// only proceed if there is data to work with
		if ($newProductIds) {
			$this->addProductIds($newProductIds);
		}

		return $this;
	}

	public function writeCookie()
	{
		if (Mage::getStoreConfigFlag('web/guestcookies/viewed')) {
			$this->_updateCookie(implode(' ', $this->getProductIds()));
		}

		return $this;
	}

}

