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
		'userid', 'username', 'email', 'password', 'passwordSalt', 'usergroup'
	);

	protected function select($where = null)
	{
		$select = new Select();

		$select->from($this->getTable());

		$select->columns(array_diff(
			$this->getColumns(),
			array('password', 'passwordSalt')
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
			array('password', 'passwordSalt')
		));

		return parent::selectWith($select);
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

		unset($data['userid']);
		
		return $this->insert($data);
	}

	public function updateUser(User $user)
	{
		return $this->update(
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