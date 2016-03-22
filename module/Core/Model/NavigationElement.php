<?php

namespace Core\Model;

class NavigationElement extends AbstractModel
{
	public $id;
	public $label;
	public $route;
	public $uri;	
	public $resource;
	public $privilege;	
	public $menu;
	public $order;
	public $parent;
	public $module;
	public $active;
}