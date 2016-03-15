<?php

namespace Core\Model;

abstract class AbstractModel
{
	public function __construct($data = null) 
	{
		if ($data) {
			if (is_array($data)) {
				$this->exchangeArray($data);
			} else {
				$this->exchangeObject($data);
			}
		}
	}
	
	public function exchangeObject($data) 
	{
		foreach ($this as $key => $value) {
			$this->$key = (!empty($data->$key)) ? $data->$key : null;
		}
	}
	
	public function exchangeArray(Array $data) 
	{
		foreach ($this as $key => $value) {
			$this->$key = (!empty($data[$key])) ? $data[$key] : null;
		}
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}