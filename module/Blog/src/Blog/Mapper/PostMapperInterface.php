<?php
 namespace Blog\Mapper;

 use Blog\Model\PostInterface;

 interface PostMapperInterface
 {
     public function find($postid);
     public function findAll();
     public function save(PostInterface $postObject);
     public function delete(PostInterface $postObject);
 }