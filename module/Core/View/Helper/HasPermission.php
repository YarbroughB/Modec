<?php

namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Permissions\Acl\Acl;

class HasPermission extends AbstractHelper
{
	static protected $acl;
	static protected $role;
	
	public function __invoke($resource, $privilege = null)
	{
		return static::$acl->isAllowed(static::$role, $resource, $privilege);
	}
	
	static public function setAcl(Acl $acl)
	{
		static::$acl = $acl;
	}
	
	static public function setRole($role)
	{
		static::$role = $role;
	}
}
