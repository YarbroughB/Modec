<?php
namespace Core\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
	public function __construct($serviceLocator)
	{
		// Filter the username
		$this->add(array(
			'name'     => 'username',
			'required' => true,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
		));

		// Filter the password
		$this->add(array(
			'name'     => 'password',
			'required' => true,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
		));
	}
}