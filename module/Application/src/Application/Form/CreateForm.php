<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Csrf;

class CreateForm extends Form {

    public function __construct($name) {
        
        parent::__construct($name);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'username',
            'type' => 'text',
            'options' => array(
                'label' => 'Username',
                'id' => 'username',           
            )
        ));

       $this->add(array(
            'name' => 'password',
            'type' => 'text',
            'options' => array(
                'label' => 'Password',
                'id' => 'password',
            )
       ));
       
	   $this->add(array(
            'name' => 'repassword',
            'type' => 'text',
            'options' => array(
                'label' => 'Enter your password again.',
                'id' => 'repassword',
            )
       ));
	   
       $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'createCsrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
        ));
        
        $this->add(array(
            'name' => 'create',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Create',
            ),
        ));
		
		$this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Back',
				'onclick' => 'location.href="create/login"',
            ),
        ));
    }
}