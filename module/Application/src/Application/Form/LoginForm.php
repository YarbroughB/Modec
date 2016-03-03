<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Csrf;

class LoginForm extends Form {

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
            'type' => 'password',
            'options' => array(
                'label' => 'Password',
                'id' => 'password',
            )
       ));
       
       $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'loginCsrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
            ),
        ));
		
		$this->add(array(
            'name' => 'newUser',
            'attributes' => array(
                'type' => 'button',
                'value' => 'New User',
				'onclick' => 'location.href="login/create"',
            ),
        ));
    }
}