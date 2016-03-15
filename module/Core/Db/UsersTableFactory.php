<?php

namespace Core\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Model\User;

class UsersTableFactory extends AbstractTableFactory
{
	protected function getTable()
	{
		return UsersTable::getTable();
	}

	protected function getModel()
	{
		return new User();
	}
	
	protected function createTable(TableGateway $tableGateway)
	{
		return new UsersTable($tableGateway);
	}
}
