<?php

namespace Core\Model;

abstract class AbstractModel
{
	public function __construct($data = null) 
	{
		if ($data) {		
			$this->populate($data);
		}
	}

	public function exchangeArray(Array $data) 
	{
		// Keep a copy to return
		$return = $this->getArrayCopy();

		// Copy the data
		$this->_populate($data);
		
		// Return the copy
		return $return;
	}

	public function populate($data)
	{
		// Make sure the data is an array
		if (is_object($data)) {
			if (method_exists($data, 'getArrayCopy')) {
				$data = $data->getArrayCopy();
			} else {
				$data = get_object_vars($data);
			}
		}

		// Reuse code we already wrote
		$this->_populate($data);
	}

	protected function _populate(Array $data)
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