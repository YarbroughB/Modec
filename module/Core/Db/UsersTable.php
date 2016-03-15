<?php

namespace Core\Db;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class UsersTable extends AbstractTable
{
	protected function getSafeSelect()
	{
		$columns = $this->getColumns();
		
		unset($columns['password']);
		unset($columns['password_salt']);

		$select = new Select();

		$select->from(
			$this->tableGateway->getTable()
		);

		$select->columns($columns);

		return $select;
	}

	public function fetchAll()
	{
		return $this->tableGateway->selectWith(
			$this->getSafeSelect()
		);
	}

	public function getUser($userid)
	{
		$rowset = $this->tableGateway->selectWith(
			$this->getSafeSelect()
		);

		return $rowset->current();
	}

	public function saveUser(User $user)
	{
		$data = $user->getArrayCopy();
		$userid = (int) $user->userid;

		if ($userid == 0) {
			return $this->tableGateway->insert($data);
		}

		if ($this->getUser($userid)) {
			return $this->tableGateway->update($data, array('userid' => $userid));
		}
		
		return null;
	}
	
	public function deleteUser($userid)
	{
		return $this->tableGateway->delete(array('userid' => (int) $userid));
	}	
}