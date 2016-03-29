<?php
 namespace Blog\Service;

 use Blog\Model\Post;
 use Blog\Model\PostInterface;
 use Blog\Mapper\PostMapperInterface;
  
 class PostService implements PostServiceInterface
 {
	 protected $postMapper;
	 public function __construct(PostMapperInterface $postMapper)
     {
         $this->postMapper = $postMapper;
     }
     public function findAllPosts() 
     {
		 return $this->postMapper->findAll();
     }
     public function findPost($postid)  
     {
		 return $this->postMapper->find($postid);
     }
     public function savePost(PostInterface $post)
     {
         return $this->postMapper->save($post);
     }
     public function deletePost(PostInterface $post)
     {
         return $this->postMapper->delete($post);
     }
 }