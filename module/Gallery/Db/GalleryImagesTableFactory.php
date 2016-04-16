<?php

namespace Gallery\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Db\AbstractTableFactory;

use Gallery\Model\GalleryImage;

class GalleryImagesTableFactory extends AbstractTableFactory
{
	protected function getTable()
	{
		return GalleryImagesTable::getTable();
	}

	protected function getModel()
	{
		return new GalleryImage();
	}
	
	protected function createTable(TableGateway $tableGateway)
	{
		return new GalleryImagesTable($tableGateway);
	}
}
