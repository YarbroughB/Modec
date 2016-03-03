<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class DataAccess
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
	public function getUser($username)
    {
		$username = (string) $username;
        $rowset = $this->tableGateway->select(array('username' => $username));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $username");
        }
        return $row;
    }
	
	public function userExists($username)
    {
		$username = (string) $username;
        $rowset = $this->tableGateway->select(array('username' => $username));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return true;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function saveUser($data)
    {
		//$username = (!empty($data['username'])) ? $data['username'] : null;
        //$password  = (!empty($data['password'])) ? $data['password'] : null;
		$dbArgs = array(
			'username' => ((!empty($data['username'])) ? $data['username'] : null),
			'password'  => ((!empty($data['password'])) ? $data['password'] : null),
		);
		$this->tableGateway->insert($dbArgs);
    }

    public function deleteUser(String $username)
    {
        $this->tableGateway->delete(array('username' => $username));
    }
}