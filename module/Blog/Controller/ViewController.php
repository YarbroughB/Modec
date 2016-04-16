<?php

namespace Blog\Controller;

use Zend\View\Model\ViewModel;

use Core\Controller\AbstractActionController;

class ViewController extends AbstractActionController
{
	public function indexAction()
	{
		// Check if the user has permission to this action
		if (!$this->hasPermission('blog', 'view')) {
			return $this->permissionDenied();
		}
		
		// Get the posts from the database
		$postsTable = $this->getServiceLocator()->get('BlogPostsTable');
		$posts = $postsTable->fetchAll();
		
		//! @todo Paginate this!

		// Display the view
		$view = new ViewModel(array(
			'posts' => $posts
		));

		$view->setTemplate('blog/index');

		return $view;
	}

	public function viewAction()
	{
		// Check if the user has permission to this action
		if (!$this->hasPermission('blog', 'view')) {
			return $this->permissionDenied();
		}
		
		// Get the post id from the request
		$postid = $this->params('id');

		// Get the post from the database
		$postsTable = $this->getServiceLocator()->get('BlogPostsTable');
		$post = $postsTable->getPost($postid);
		
		// Check that a post was found
		if (!$post) {
			return $this->pageNotFound();
		}

		// Display the view
		$view = new ViewModel(array(
			'post' => $post
		));

		$view->setTemplate('blog/view');

		return $view;
	}
}
