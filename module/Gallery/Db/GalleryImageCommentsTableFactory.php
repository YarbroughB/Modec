<?php

namespace Gallery\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Db\AbstractTableFactory;

use Gallery\Model\GalleryImageComment;

class GalleryImageCommentsTableFactory extends AbstractTableFactory
{
	protected function getTable()
	{
		return GalleryImageCommentsTable::getTable();
	}

	protected function getModel()
	{
		return new GalleryImageComment();
	}
	
	protected function createTable(TableGateway $tableGateway)
	{
		return new GalleryImageCommentsTable($tableGateway);
	}
}
