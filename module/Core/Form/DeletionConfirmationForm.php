<?php
namespace Core\Form;

use Zend\Form\Form;

class DeletionConfirmationForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct($name, $options);

		// Set the form method
		$this->setAttribute('method', 'post');

		// Add the confirmation buttons
		$this->add(array(
			'name' => 'accept',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Yes',
			),
		));

		$this->add(array(
			'name' => 'decline',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'No',
			),
		));
	}
}
