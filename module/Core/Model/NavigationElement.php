<?php

namespace Core\Model;

class NavigationElement
{
	public $id;
	public $label;
	public $route;
	public $uri;
	public $menu;
	public $order;
	public $parent;
	public $module;
	public $active;

	public function __construct($data = null) 
	{
		if ($data) {
			$this->id     = (!empty($data->id))     ? $data->id     : null;
			$this->label  = (!empty($data->label))  ? $data->label  : null;
			$this->route  = (!empty($data->route))  ? $data->route  : null;
			$this->uri    = (!empty($data->uri))    ? $data->uri    : null;
			$this->menu   = (!empty($data->menu))   ? $data->menu   : null;
			$this->order  = (!empty($data->order))  ? $data->order  : null;
			$this->parent = (!empty($data->parent)) ? $data->parent : null;
			$this->module = (!empty($data->module)) ? $data->module : null;
			$this->active = (!empty($data->active)) ? $data->active : null;
		}
	}
	
	public function exchangeArray($data) 
	{
		$this->id     = (!empty($data['id']))     ? $data['id']     : null;
		$this->label  = (!empty($data['label']))  ? $data['label']  : null;
		$this->route  = (!empty($data['route']))  ? $data['route']  : null;
		$this->uri    = (!empty($data['uri']))    ? $data['uri']    : null;
		$this->menu   = (!empty($data['menu']))   ? $data['menu']   : null;
		$this->order  = (!empty($data['order']))  ? $data['order']  : null;
		$this->parent = (!empty($data['parent'])) ? $data['parent'] : null;
		$this->module = (!empty($data['module'])) ? $data['module'] : null;
		$this->active = (!empty($data['active'])) ? $data['active'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}