<?php
 namespace Blog\Controller;

 use Blog\Service\PostServiceInterface;
 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

 class ListController extends AbstractActionController
 {
	 protected $postService;

     public function __construct(PostServiceInterface $postService)
     {
         $this->postService = $postService;
     }
	 public function indexAction()
     {
		 return new ViewModel(array(
             'posts' => $this->postService->findAllPosts()
         )); 		 
     }
	 public function postbyidAction()
     {
         $postid = $this->params()->fromRoute('blogid');

         try {
             $post = $this->postService->findPost($postid);
         } catch (\InvalidArgumentException $ex) {
             return $this->redirect()->toRoute('blog');
         }

         return new ViewModel(array(
             'post' => $post
         ));
     }
 }