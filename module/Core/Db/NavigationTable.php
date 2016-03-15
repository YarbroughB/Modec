<?php

namespace Core\Db;

use Zend\Db\Sql\Where;

class NavigationTable extends AbstractTable
{
	public function fetchAllActive()
	{
		return $this->tableGateway->select(array('active' => 1));
	}
	
	public function fetchMenu($menu, $loadedModules = null)
	{
		$where = new Where();

		$where->equalTo('menu', $menu);
		$where->equalTo('active', 1);

		$where->in('module', $loadedModules);

		return $this->tableGateway->select($where);
	}
}