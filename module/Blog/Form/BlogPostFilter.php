<?php
namespace Blog\Form;

use Zend\InputFilter\InputFilter;

class BlogPostFilter extends InputFilter
{
	public function __construct($serviceLocator)
	{
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
						'max'	   => 6,  //! @todo This should probably come from a setting!
						'max'	   => 100,
					),
				),
			),
		));

		// Filter the text
		$this->add(array(
			'name'     => 'text',
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
						'max'	   => 15,  //! @todo This should probably come from a setting!
						'max'	   => 65535,
					),
				),
			),
		));
	}
}
