<?php

namespace Core\Model;

class User extends AbstractModel
{
	public $userid;
	public $username;
	public $email;
	public $password;
	public $password_salt;
	public $usergroup;

	protected function _populate(Array $data) 
	{
		// Copy the user data
		parent::_populate($data);
		
		// Check for usergroup data
		$usergroupPrefix       = \Core\Db\UsergroupsTable::getPrefix();
		$usergroupPrefixLength = strlen($usergroupPrefix);
		$usergroupData         = array();

		foreach ($data as $key => $value) {
			if (strpos($key, $usergroupPrefix) === 0) {
				$key = substr($key, $usergroupPrefixLength);
				$usergroupData[$key] = $value;
			}
		}

		if (!empty($usergroupData)) {
			if (!isset($usergroupData['id'])) {
				$usergroupData['id'] = $data['usergroup'];
			}

			$this->usergroup = new Usergroup($usergroupData);
		}
	}

	public function getArrayCopy()
	{
		$array = parent::getArrayCopy($this);
		
		if ($this->usergroup instanceof Usergroup) {
			$array['usergroup'] = $this->usergroup->id;
		}
		
		return $array;
	}
}
