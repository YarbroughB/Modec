<?php
 namespace Blog\Model;

 interface PostInterface
 {
     public function getPostid();
     public function getPosttitle();
     public function getPosttext();
	 public function getUserid(); 
 }