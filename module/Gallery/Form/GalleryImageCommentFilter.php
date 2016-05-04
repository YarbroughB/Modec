<?php

namespace Gallery\Form;

use Zend\InputFilter\InputFilter;

class GalleryImageCommentFilter extends InputFilter
{
	public function __construct($serviceLocator)
	{
		// Filter the content
		$this->add(array(
			'name'     => 'content',
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
