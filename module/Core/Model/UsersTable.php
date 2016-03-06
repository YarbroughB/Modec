<?php

namespace Core\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable
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

	public function getUser($userid)
	{
		$rowset = $this->tableGateway->select(array('userid' => (int) $userid));
		$row = $rowset->current();

		if (!$row) {
			throw new \Exception("Could not find user with id $userid");
		}

		return $row;
	}

	public function saveUser(User $user)
	{
		$data = $user->getArrayCopy();
		$userid = (int) $user->userid;

		if ($userid == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getUser($userid)) {
				$this->tableGateway->update($data, array('userid' => $userid));
			} else {
				throw new \Exception('Attempting to edit a user that does not exist');
			}
		}
	}
	
	public function deleteUser($userid)
	{
		$this->tableGateway->delete(array('userid' => (int) $userid));
	}	
}