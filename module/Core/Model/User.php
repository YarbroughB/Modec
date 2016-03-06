<?php

namespace Core\Model;

class User
{
	public $userid;
	public $username;
	public $password;
	public $password_salt;

	public function exchangeArray($data) 
	{
		$this->userid        = (!empty($data['userid']))        ? $data['userid']        : null;
		$this->username      = (!empty($data['username']))      ? $data['username']      : null;
		$this->password      = (!empty($data['password']))      ? $data['password']      : null;
		$this->password_salt = (!empty($data['password_salt'])) ? $data['password_salt'] : null;
	}	

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}