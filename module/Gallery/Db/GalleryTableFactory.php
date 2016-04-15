<?php

namespace Gallery\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Db\AbstractTableFactory;

use Gallery\Model\Gallery;

class GalleryTableFactory extends AbstractTableFactory
{
	protected function getTable()
	{
		return GalleryTable::getTable();
	}

	protected function getModel()
	{
		return new Gallery();
	}
	
	protected function createTable(TableGateway $tableGateway)
	{
		return new GalleryTable($tableGateway);
	}
}
