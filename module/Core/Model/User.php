<?php

namespace Core\Model;

class User extends AbstractModel
{
	protected $userid;
	protected $username;
	protected $email;
	protected $password;
	protected $passwordSalt;
	protected $usergroup;

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

			$this->setUsergroup($usergroupData);
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

	protected function setPassword($value)
	{
		if (empty($value)) {
			$this->password = null;
			$this->passwordSalt = null;
			return;
		}

		// Create the password salt
		$this->passwordSalt = '';
		
		for ($i = 0; $i < 32; $i++) {
			$this->passwordSalt .= chr(rand(33, 126));
		}

		// Encrypt the password
		$this->password = md5($value . $this->passwordSalt);
	}
	
	protected function setPasswordSalt($value)
	{
		if (!isset($value)) { return; }

		throw new \Exception("Password salt cannot be set manually!");
	}

	protected function setUsergroup($value)
	{
		if (is_array($value)) {
			$this->usergroup = new Usergroup($value);
		} else {
			$this->usergroup = $value;
		}
	}
}
