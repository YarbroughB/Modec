<?php

namespace Core\Form;

use Zend\InputFilter\InputFilter;

class RegistrationFilter extends InputFilter
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
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'max'	  => 50,
					),
				),
				array(
					'name'    => 'Zend\Validator\Db\NoRecordExists',
					'options' => array(
						'table'   => 'users',
						'field'   => 'username',
						'adapter' => $serviceLocator->get('DbAdapter'),
					),
				),
			),
		));

		// Filter the email
		$this->add(array(
			'name'     => 'email',
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
						'max'	   => 150,
					),
				),
				array(
					'name'    => 'EmailAddress',
				),
				array(
					'name'    => 'Zend\Validator\Db\NoRecordExists',
					'options' => array(
						'table'   => 'users',
						'field'   => 'email',
						'adapter' => $serviceLocator->get('DbAdapter'),
					),
				),
			),
		));

		// Filter the email confirmation
		$this->add(array(
			'name'     => 'email_confirm',
			'required' => true,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name'    => 'Identical',
					'options' => array(
						'token' => 'email',
					),
				),
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
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min'	  => 6
					),
				),
			),
		));	

		// Filter the password confirmation
		$this->add(array(
			'name'     => 'password_confirm',
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
						'min'	  => 6,
					),
				),
				array(
					'name'    => 'Identical',
					'options' => array(
						'token' => 'password',
					),
				),
			),
		));		
	}
}