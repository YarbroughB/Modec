<?php

namespace Gallery\Form;

use Zend\Form\Form;

class GalleryImageCommentForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct($name, $options);

		// Set the form method
		$this->setAttribute('method', 'post');

		// Add the post content field
		$this->add(array(
			'name' => 'content',
			'attributes' => array(
				'type' => 'textarea',
			),
			'options' => array(
				'label' => 'Comment',
			),
		));
		
		$this->add(array(
		  'name' => 'imageid',
			'attributes' => array(
				'type' => 'hidden',
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
