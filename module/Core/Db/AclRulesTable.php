<?php

namespace Core\Db;

class AclRulesTable extends AbstractTable
{
	static protected $prefix  = 'rules';
	static protected $table   = 'acl_rules';
	static protected $columns = array('id', 'usergroup', 'resource', 'privilege', 'action');
}
