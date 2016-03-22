<?php

namespace Core\Db;

use Zend\Db\Sql\Where;

class NavigationTable extends AbstractTable
{
	static protected $table   = 'navigation';
	static protected $columns = array(
		'id', 'label', 'route', 'uri', 'resource', 'priviledge', 'menu', 'order', 'parent', 'module', 'active'
	);

	public function fetchAllActive()
	{
		return $this->select(array('active' => 1));
	}
	
	public function fetchMenu($menu, $loadedModules = null)
	{
		$where = new Where();

		$where->equalTo('menu', $menu);
		$where->equalTo('active', 1);

		$where->in('module', $loadedModules);

		return $this->select($where);
	}
}