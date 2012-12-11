<?php

/* @var $this Mage_Core_Model_Resource_Setup */
$this->startSetup();

$quotes = new Varien_Db_Ddl_Table();
$quotes->setName($this->getTable('guestcookies/visitor'));

// Reference to foreign table
$quotes->addColumn('visitor_id', Varien_Db_Ddl_Table::TYPE_BIGINT, 20, array(
	// primary value is exact copy of quote's entity_id, it is one-to-one relationship
	// not autoincrement so remember to unmark it as such in model
	'primary'	=> true,
	// mimic foreign key exactly or constraint cannot work
	'nullable'	=> false,
	'unsigned'	=> true
));
$quotes->addForeignKey('FK_GUESTCOOKIES_VISITOR_ID_LOG_VISITOR_VISITOR_ID',
	'visitor_id', $this->getTable('log/visitor'), 'visitor_id',
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
