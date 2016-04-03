<?php

namespace Blog\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Db\AbstractTableFactory;

use Blog\Model\BlogPost;

class BlogPostsTableFactory extends AbstractTableFactory
{
	protected function getTable()
	{
		return BlogPostsTable::getTable();
	}

	protected function getModel()
	{
		return new BlogPost();
	}
	
	protected function createTable(TableGateway $tableGateway)
	{
		return new BlogPostsTable($tableGateway);
	}
}
