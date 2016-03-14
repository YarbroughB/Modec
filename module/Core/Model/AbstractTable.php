<?php

namespace Core\Model;

use Zend\Db\TableGateway\TableGateway;

abstract class AbstractTable
{
	protected $tableGateway;
	protected $columns;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function getColumns()
	{
		if (!$this->columns) {
			$this->columns = $this->tableGateway->getResultSetPrototype()->getArrayObjectPrototype()->getArrayCopy();
			
			foreach ($this->columns as $key => $column) {
				$this->columns[$key] = $key;
			}
		}

		return $this->columns;
	}
	
	public function fetchAll()
	{
		return $this->tableGateway->select();
	}
}