<?php

namespace Core\Db;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Where;

abstract class AbstractTable
{
	static protected $table;
	static protected $columns;

	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	// Get Table
	static public function getTable()
	{
		return static::$table;
	}

	// Get Columns
	static function getColumns()
	{
		return static::$columns;
	}

	// Query Operations
	protected function select($where = null)
	{
		return $this->tableGateway->select($where);
	}
	
	protected function selectWith(Select $select)
	{
		return $this->tableGateway->selectWith($select);
	}

	protected function insert($set)
	{
		return $this->tableGateway->insert($set);
	}

	protected function insertWith(Insert $insert)
	{
		return $this->tableGateway->insertWith($insert);
	}

	protected function update($set, $where = null)
	{
		return $this->tableGateway->update($set, $where);
	}

	/*protected function updateOrInsert($set, $where = null)
	{
		$affectedRows = $this->update($set, $where);

		if (!$affectedRows) {
			$affectedRows = $this->insert($set);
		}

		return $affectedRows;
	}*/

	protected function updateWith(Update $update)
	{
		return $this->tableGateway->updateWith($update);
	}

	protected function delete($where)
	{
		return $this->tableGateway->delete($where);
	}

	protected function deleteWith(Delete $delete)
	{
		return $this->tableGateway->deleteWith($delete);
	}
	
	// Default Public Operations
	public function fetchAll()
	{
		return $this->select();
	}
}