<?php

namespace Core\Db;

class AclResourcesTable extends AbstractTable
{
	static protected $prefix  = 'resource';
	static protected $table   = 'acl_resources';
	static protected $columns = array('id', 'parent', 'module');
}
