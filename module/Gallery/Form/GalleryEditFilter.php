<?php

namespace Gallery\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator;

class GalleryEditFilter extends InputFilter
{
	public function __construct($serviceLocator)
	{
		// Filter the description
		$this->add(array(
			'name'     => 'description',
			'required' => true,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
			  array(
					'name' => 'StringLength',
					'options' => array(
						'max' => 200,
					)
				)
			),
		));
	}
}
