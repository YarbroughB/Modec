<?php

namespace Core\Model;

class NavigationElement extends AbstractModel
{
	protected $id;
	protected $label;
	protected $route;
	protected $params;
	protected $uri;
	protected $resource;
	protected $privilege;	
	protected $menu;
	protected $order;
	protected $parent;
	protected $module;
	protected $active;

	public function getArrayCopy()
	{
		$array = parent::getArrayCopy($this);
		
		if (is_array($this->params)) {
			$array['params'] = serialize($this->params);
		}
		
		return $array;
	}
	
	protected function setParams($value)
	{
		if (is_string($value)) {
			$this->params = unserialize($value);
		} else {
			$this->params = $value;
		}
	}
}