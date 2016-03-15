<?php

namespace Core\Db;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

use Core\Model\User;

class UsersTable extends AbstractTable
{
	static protected $table = 'users';
	static protected $columns = array(
		'userid', 'username', 'email', 'password', 'password_salt', 'usergroup'
	);

	protected function select($where = null)
	{
		$select = new Select();

		$select->from($this->getTable());
		$select->columns(array_diff(
			$this->getColumns(),
			array('password', 'password_salt')
		));
		
		if ($where) {
			$select->where($where);
		}

		return $this->tableGateway->selectWith($select);
	}
	
	protected function selectWith(Select $select)
	{
		return $this->tableGateway->selectWith($select);
	}
	
	public function fetchAll()
	{
		return $this->select();
	}

	public function getUser($userid)
	{
		$rowset = $this->select(array(
			'userid' => (int) $userid,
		));

		return $rowset->current();
	}

	public function addUser(User $user)
	{
		unset($user->userid);

		return $this->insert(
			$user->getArrayCopy()
		);
	}

	public function updateUser(User $user)
	{
		return $this->tableGateway->update(
			$user->getArrayCopy(),
			array('userid' => (int) $user->userid)
		);
	}
	
	public function deleteUser($userid)
	{
		return $this->delete(array(
			'userid' => (int) $userid
		));
	}	
}