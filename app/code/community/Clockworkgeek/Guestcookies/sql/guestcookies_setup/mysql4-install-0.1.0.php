<?php

/* @var $this Mage_Core_Model_Resource_Setup */
$this->startSetup();

$quotes = new Varien_Db_Ddl_Table();
$quotes->setName($this->getTable('guestcookies/quote'));

// Reference to foreign table
$quotes->addColumn('quote_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
	// primary value is exact copy of quote's entity_id, it is one-to-one relationship
	// not autoincrement so remember to unmark it as such in model
	'primary'	=> true,
	// mimic foreign key exactly or constraint cannot work
	'nullable'	=> false,
	'unsigned'	=> true
));
$quotes->addForeignKey('FK_GUESTCOOKIES_QUOTE_ID_SALES_QUOTE_ENTITY_ID',
	'quote_id', $this->getTable('sales/quote'), 'entity_id',
	Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);

// Token key to be stored in cookie
$quotes->addColumn('token', Varien_Db_Ddl_Table::TYPE_CHAR, 32, array(
	'nullable'	=> false
));
$quotes->addIndex('IDX_TOKEN', 'token', array(
	'unique'	=> true
));

$this->getConnection()->createTable($quotes);
$this->endSetup();
