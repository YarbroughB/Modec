<?php

namespace Core\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;

class NavigationTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAll()
	{
		return $this->tableGateway->select();
	}
	
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