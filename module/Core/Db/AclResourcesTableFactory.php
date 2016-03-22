<?php

namespace Core\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Model\AclResource;

class AclResourcesTableFactory extends AbstractTableFactory
{
	protected function getTable()
	{
		return AclResourcesTable::getTable();
	}

	protected function getModel()
	{
		return new AclResource();
	}
	
	protected function createTable(TableGateway $tableGateway)
	{
		return new AclResourcesTable($tableGateway);
	}
}
