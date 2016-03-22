<?php

namespace Core\Model;

class AclRule extends AbstractModel
{
	public $id;
	public $usergroup;
	public $resource;
	public $privilege;
	public $action;
}