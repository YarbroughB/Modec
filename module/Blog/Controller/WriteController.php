<?php

namespace Blog\Controller;

use Zend\View\Model\ViewModel;

use Core\Controller\AbstractActionController;

use Blog\Form\BlogPostForm;
use Blog\Form\BlogPostFilter;
use Blog\Model\BlogPost;

class WriteController extends AbstractActionController
{
	public function addAction()
	{
		// Check if the user has permission to this action
		$user = $this->identity();

		//if (!$user || !$this->hasPermission('blog', 'add')) {
		if (!$user) {
			return $this->permissionDenied();
		} //! @todo Add this!

		// Create the form		
		$form = new BlogPostForm();
		$form->setAttribute('action', $this->url()->fromRoute('blog/add'));
		
		// Process POST requests
		$request = $this->getRequest();

        if ($request->isPost()) {
			// Setup the form data and input filter
			$form->setData($request->getPost());
			$form->setInputFilter(
				new BlogPostFilter($this->getServiceLocator())
			);

			// Check if the form is valid
			if ($form->isValid()) {
				// Collect the post data
				$data = $form->getData();

				$data->id     = null;
				$data->userid = $user->userid;
				$data->date   = time();

				// Add the post to the database
				$postsTable = $this->getServiceLocator()->get('BlogPostsTable');
				$data->id = $postsTable->addPost($data);
				
				// Redirect the user to their newly made post
				return $this->redirect()->toRoute('blog/view', $data->getCleanArrayCopy());
			}
		}

		// Display the form
		$view = new ViewModel(array(
			'form' => $form
		));
		
		$view->setTemplate('blog/add');

		return $view;
	}

	public function editAction()
	{
		// Check if the user has permission to this action
		$user = $this->identity();

		/*if (!$user || !$this->hasPermission('blog', 'edit')) {
			return $this->permissionDenied();
		}*/ //! @todo Add this!
		
		// Get the post id from the request
		$postid = $this->params('id');

		// Get the post from the database
		$postsTable = $this->getServiceLocator()->get('BlogPostsTable');
		$post = $postsTable->getPost($postid);
		
		// Check that a post was found
		if (!$post) {
			return $this->pageNotFound();
		}

		// Check that they are editing their own post or have permission to edit other's posts
		if ($post->userid != $user->userid || !$this->hasPermission('blog', 'edit-others')) {
			return $this->permissionDenied();
		} //! @todo Add this!

		// Create the form
		$form = new BlogPostForm();
		$form->setAttribute('action', $this->url()->fromRoute('blog/edit', $post->getCleanArrayCopy()));

		// Set the post data in the form
		$form->setData($post->getArrayCopy());

		// Process POST requests
		$request = $this->getRequest();

        if ($request->isPost()) {
			// Setup the form data and input filter
			$form->setData($request->getPost());
			$form->setInputFilter(
				new BlogPostFilter($this->getServiceLocator())
			);

			// Check if the form is valid
			if ($form->isValid()) {
				// Collect the post data
				$data = $form->getData();

				$data->id     = $post->id;
				$data->userid = $post->userid;
				$data->date   = $post->date;

				$data->editUserid = $user->userid;
				$data->editDate   = time();

				// Add the post to the database
				$postsTable = $this->getServiceLocator()->get('BlogPostsTable');
				$postsTable->updatePost($data);
				
				// Redirect the user to their newly made post
				return $this->redirect()->toRoute('blog/view', $data->getCleanArrayCopy());
			}
		}

		// Display the form
		$view = new ViewModel(array(
			'form' => $form
		));
		
		$view->setTemplate('blog/add');

		return $view;
	}
}
