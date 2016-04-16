<?php

namespace Gallery\Form;

use Zend\InputFilter\InputFilter;

class GalleryImageFilter extends InputFilter
{
	public function __construct($serviceLocator)
	{
		// Filter the image
		$this->add(array(
			'name'     => 'image',
			'required' => true,
			'validators' => array(
				array(
					'name'    => 'File\MimeType',
					'options' => array(
						'enableHeaderCheck' => true,
						'mimeType'          => array(
							'image/bmp', 'image/gif', 'image/jpeg', 'image/png',
						),
					),
				),
			),
		));

		// Filter the title
		$this->add(array(
			'name'     => 'title',
			'required' => true,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min'	   => 6,  //! @todo This should probably come from a setting!
						'max'	   => 100,
					),
				),
			),
		));

		// Filter the description
		$this->add(array(
			'name'     => 'description',
			'required' => false,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min'      => 10,  //! @todo This should probably come from a setting!
						'max'	   => 200,
					),
				),
			),
		));
	}
}
