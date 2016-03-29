<?php
 namespace Blog\Controller;

 use Blog\Service\PostServiceInterface;
 use Zend\Form\FormInterface;
 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

 class WriteController extends AbstractActionController
 {
     protected $postService;

     protected $postForm;

     public function __construct(
         PostServiceInterface $postService,
         FormInterface $postForm
     ) {
         $this->postService = $postService;
         $this->postForm    = $postForm;
     }

     public function addpostAction()
     {
		 $request = $this->getRequest();

         if ($request->isPost()) {
             $this->postForm->setData($request->getPost());

             if ($this->postForm->isValid()) {
                 try {
                     $this->postService->savePost($this->postForm->getData());

                     return $this->redirect()->toRoute('blog');
                 } catch (\Exception $e) {
					 return $this->redirect()->toRoute('blog');
                 }
             }
         }

         return new ViewModel(array(
             'form' => $this->postForm
         ));
     }
	 
	 public function editpostAction()
     {
         $request = $this->getRequest();
         $post    = $this->postService->findPost($this->params('idForBlog'));

         $this->postForm->bind($post);

         if ($request->isPost()) {
             $this->postForm->setData($request->getPost());

             if ($this->postForm->isValid()) {
                 try {
                     $this->postService->savePost($post);

                     return $this->redirect()->toRoute('blog');
                 } catch (\Exception $e) {
                     die($e->getMessage());
					 return $this->redirect()->toRoute('blog');
                 }
             }
         }

         return new ViewModel(array(
             'form' => $this->postForm
         ));
     }
 }