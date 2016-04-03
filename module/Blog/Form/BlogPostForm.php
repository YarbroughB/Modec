<?php
namespace Blog\Form;

use Zend\Form\Form;
//use Zend\Stdlib\Hydrator\ClassMethods;

use Blog\Model\BlogPost;

class BlogPostForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct($name, $options);

		// Set the form object
		$this->setObject(new BlogPost());

		// Set the form hydrator
		//$this->setHydrator(new ClassMethods());

		// Set the form method
		$this->setAttribute('method', 'post');

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
		
		// Add the post text field
		$this->add(array(
			'name' => 'text',
			'attributes' => array(
				'type' => 'textarea',
			),
			'options' => array(
				'label' => 'Body',
			),
		));
		
		// Add the post id field
		/*$this->add(array(
			'name' => 'id',
			'attributes' => array(
				'type'  => 'hidden',
			),
		));*/

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
