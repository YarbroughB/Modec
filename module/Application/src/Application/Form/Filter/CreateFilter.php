<?php
namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;

class CreateFilter extends InputFilter {

    public function __construct(){
        
        $isEmpty = \Zend\Validator\NotEmpty::IS_EMPTY;
        $isMatch = \Zend\Validator\Identical::NOT_SAME;
		
        $this->add(array(
            'name' => 'username',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            $isEmpty => 'Username can not be empty.'
                        )
                    ),
                    'break_chain_on_failure' => true
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            $isEmpty => 'Password can not be empty.'
                        )
                    )
                )
            )
        ));
		
		$this->add(array(
            'name' => 'repassword',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            $isEmpty => 'Password can not be empty.'
                        )
                    )
                ),
				array(
					'name' => 'Identical',
					'options' => array(
                        'token' => 'password',
						'messages' => array(
                            $isMatch => 'Passwords do not match.'
                        )
                    )
				)
            )
        ));
    }
}