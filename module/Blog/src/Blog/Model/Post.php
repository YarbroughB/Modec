<?php
 namespace Blog\Model;

 class Post implements PostInterface
 {
     protected $postid;
	 protected $userid; 
     protected $posttitle;
     protected $posttext;
     public function getPostid()
     {
         return $this->postid;
     }
     public function setPostid($postid)
     {
         $this->postid = $postid;
     }
	 public function getUserid()
     {
         return $this->userid;
     }
     public function setUserid($userid)
     {
         $this->userid = $userid;
     }
     public function getPosttitle()
     {
         return $this->posttitle;
     }
     public function setPosttitle($posttitle)
     {
         $this->posttitle = $posttitle;
     }
     public function getPosttext()
     {
         return $this->posttext;
     }
     public function setPosttext($posttext)
     {
         $this->posttext = $posttext;
     }
 }