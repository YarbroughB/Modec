<?php
 namespace Blog\Form;

 use Blog\Model\Post;
 use Zend\Form\Fieldset;
 use Zend\Stdlib\Hydrator\ClassMethods;

 class PostFieldset extends Fieldset
 {
    public function __construct($name = null, $options = array())
     {
         parent::__construct($name, $options);
		 
		 $this->setHydrator(new ClassMethods(false));
         $this->setObject(new Post());

         $this->add(array(
             'type' => 'hidden',
             'name' => 'postid'
         ));
		 
		 $this->add(array(
             'type' => 'text',
             'name' => 'userid',
             'options' => array(
                 'label' => 'User ID'
             )
         ));
		 
		 $this->add(array(
             'type' => 'date',
             'name' => 'dateformat',
             'options' => array(
                 'label' => 'Post Date'
             )
         ));
		 
		 $this->add(array(
             'type' => 'text',
             'name' => 'posttitle',
             'options' => array(
                 'label' => 'Blog Title'
             )
         ));
		 
         $this->add(array(
             'type' => 'text',
             'name' => 'posttext',
             'options' => array(
                 'label' => 'The Text'
             )
         ));
     }
 }