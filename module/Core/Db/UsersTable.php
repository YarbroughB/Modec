<?php

namespace Core\Db;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

use Core\Model\User;

class UsersTable extends AbstractTable
{
	static protected $prefix  = 'user';
	static protected $table   = 'users';
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

		$select->join(
			UsergroupsTable::getTable(),
			$this->getTable() . '.usergroup = ' . UsergroupsTable::getTable() . '.id',
			UsergroupsTable::getPrefixedColumns()
		);

		if ($where) {
			$select->where($where);
		}

		return parent::selectWith($select);
	}
	
	protected function selectWith(Select $select)
	{
        $selectState = $select->getRawState();

        if ($selectState['columns'] == array(Select::SQL_STAR)) {
			$selectState['columns'] = $this->getColumns();
        }

		$select->columns(array_diff(
			$selectState['columns'],
			array('password', 'password_salt')
		));

		return parent::selectWith($select);
	}

	public function encryptPassword(Array & $data)
	{
		// Check if the password was set
		if (!isset($data['password'])) { return; }
		
		// Create the password salt
		$data['password_salt'] = '';
		
		for ($i = 0; $i < 32; $i++) {
			$data['password_salt'] .= chr(rand(33, 126));
		}

		// Encrypt the password
		$data['password'] = md5($data['password'] . $data['password_salt']);
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
		$data = $user->getArrayCopy();
		$this->encryptPassword($data);
		
		unset($data['userid']);
		
		return $this->insert($data);
	}

	public function updateUser(User $user)
	{
		$data = $user->getArrayCopy();
		$this->encryptPassword($data);

		return $this->update(
			$data,
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