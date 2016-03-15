<?php

namespace Core\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Model\NavigationElement;

class NavigationTableFactory extends AbstractTableFactory
{
	protected function getTable()
	{
		return NavigationTable::getTable();
	}

	protected function getModel()
	{
		return new NavigationElement();
	}
	
	protected function createTable(TableGateway $tableGateway)
	{
		return new NavigationTable($tableGateway);
	}
}
