<?php

namespace Core\Model;

class NavigationElement extends AbstractModel
{
	public $id;
	public $label;
	public $route;
	public $params;
	public $uri;
	public $resource;
	public $privilege;	
	public $menu;
	public $order;
	public $parent;
	public $module;
	public $active;

	protected function _populate(Array $data)
	{
		parent::_populate($data);
		
		if (is_string($data['params'])) {
			$this->params = unserialize($data['params']);
		}
	}
}