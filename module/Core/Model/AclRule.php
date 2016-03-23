<?php

namespace Core\Model;

class AclRule extends AbstractModel
{
	protected $id;
	protected $usergroup;
	protected $resource;
	protected $privilege;
	protected $action;
}