<?php

namespace Core\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Model\AclRule;

class AclRulesTableFactory extends AbstractTableFactory
{
	protected function getTable()
	{
		return AclRulesTable::getTable();
	}

	protected function getModel()
	{
		return new AclRule();
	}
	
	protected function createTable(TableGateway $tableGateway)
	{
		return new AclRulesTable($tableGateway);
	}
}
