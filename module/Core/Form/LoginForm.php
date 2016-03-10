<?php
namespace Core\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('login');

		// Set the form method
		$this->setAttribute('method', 'post');

		// Add the username field
		$this->add(array(
			'name' => 'username',
			'attributes' => array(
				'type'  => 'text',
				'placeholder' => 'Username',
			),
			'options' => array(
				'label' => 'Username',
			),
		));

		// Add the password field
		$this->add(array(
			'name' => 'password',
			'attributes' => array(
				'type'  => 'password',
				'placeholder' => 'Password',
			),
			'options' => array(
				'label' => 'Password',
			),
		));

		// Add the remember me checkbox
		$this->add(array(
			'name' => 'rememberme',
			'type' => 'checkbox',
			'options' => array(
				'label' => 'Remember Me?',
			),
		));

		// Add the referer field
		$this->add(array(
			'name' => 'referer',
			'type' => 'hidden',
		));

		// Add the submit button
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Login',
			),
		)); 
	}
}