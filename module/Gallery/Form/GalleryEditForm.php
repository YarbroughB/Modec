<?php
namespace Gallery\Form;

use Zend\Form\Form;
use Zend\Form\Element\File;

class GalleryEditForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('gallery');

		// Set the form method
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');
    
		$this->add(array(
			'name' => 'photoId',
			'type' => 'Hidden',
		));

		
		// Add the username field
		$this->add(array(
			'name' => 'userid',
			'type' => 'Hidden',
		));
		
		$this->add(array(
			'name' => 'timestamp',
			'type' => 'Hidden',
		));

		// Add the description
		$this->add(array(
			'name' => 'description',
			'attributes' => array(
				'type'  => 'text',
				'placeholder' => 'Description',
			),
			'options' => array(
				'label' => 'Description',
			),
		));
		
	  $this->add(array(
			'name' => 'location',
			'type' => 'Hidden',
		));
	
		// Add the submit button
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'gallery',
			),
		)); 
	}
}