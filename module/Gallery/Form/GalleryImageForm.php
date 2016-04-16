<?php

namespace Gallery\Form;

use Zend\Form\Form;

class GalleryImageForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct($name, $options);

		// Set the form method
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');

		// Add the image field
		$this->add(array(
			'name' => 'image',
			'attributes' => array(
				'type' => 'file',
			),
			'options' => array(
				'label' => 'Image',
			),
		));

		// Add the title field
		$this->add(array(
			'name' => 'title',
			'attributes' => array(
				'type' => 'text',
			),
			'options' => array(
				'label' => 'Title',
			),
		));
		
		// Add the post description field
		$this->add(array(
			'name' => 'description',
			'attributes' => array(
				'type' => 'textarea',
			),
			'options' => array(
				'label' => 'Description',
			),
		));

		// Add the submit button
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Submit',
			),
		)); 
	}
}
