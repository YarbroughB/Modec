<?php

namespace Gallery\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator;

class GalleryFilter extends InputFilter
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
					'name'    => 'StringLength',
					'options' => array(
						'max' => 200,
					),
				),
			)
		));

		// Filter the location
		$this->add(array(
			'name'       => 'location',
			'required'   => true,
			'validators' => array(
				array(
					'name' => 'File\isImage'
				),
				array(
					'name' => 'File\Extension',
					'options' => array('extension' => 'jpeg, jpg, png'),
				),
			)
		));
	}
}
