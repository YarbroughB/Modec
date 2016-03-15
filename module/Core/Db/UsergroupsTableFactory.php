<?php

namespace Core\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Model\Usergroup;

class UsergroupsTableFactory extends AbstractTableFactory
{
	protected function getTable()
	{
		return UsergroupsTable::getTable();
	}

	protected function getModel()
	{
		return new Usergroup();
	}
	
	protected function createTable(TableGateway $tableGateway)
	{
		return new UsergroupsTable($tableGateway);
	}
}
