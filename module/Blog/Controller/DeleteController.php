<?php

namespace Blog\Controller;

use Zend\View\Model\ViewModel;

use Core\Controller\AbstractActionController;
use Core\Form\DeletionConfirmationForm;

class DeleteController extends AbstractActionController
{
	public function deleteAction()
	{
		// Check if the user has permission to this action
		$user = $this->identity();

		/*if (!$user || !$this->hasPermission('blog', 'delete')) {
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

		// Check that they are deleting their own post or have permission to delete other's posts
		if ($post->userid != $user->userid || !$this->hasPermission('blog', 'delete-others')) {
			return $this->permissionDenied();
		} //! @todo Add this!

		// Create the form		
		$form = new DeletionConfirmationForm();
		$form->setAttribute('action', $this->url()->fromRoute('blog/delete', $post->getCleanArrayCopy()));

		// Process POST requests
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			if ($request->getPost('accept') !== null) {
				if ($postsTable->deletePost($postid)) {
					$this->flashMessenger()->addSuccessMessage("Blog post successfully deleted!");

					return $this->redirect()->toRoute('blog');
				}

				$this->flashMessenger()->addErrorMessage("Blog post could not be deleted!");
			}

			return $this->redirect()->toRoute('blog/view', $post->getCleanArrayCopy());
		}

		// Display the form
		$view = new ViewModel(array(
			'form' => $form,
			'post' => $post
		));
		
		$view->setTemplate('blog/delete');

		return $view;
	}
}
