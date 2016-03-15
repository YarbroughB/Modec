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
}