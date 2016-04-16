<?php

namespace Gallery\Controller;

use Zend\View\Model\ViewModel;

use Core\Controller\AbstractActionController;
use Core\Form\DeletionConfirmationForm;

class DeleteController extends AbstractActionController
{
	public function deleteAction()
	{
		// Check if the user has permission to this action
		$user = $this->identity();

		/*if (!$user || !$this->hasPermission('gallery', 'delete')) {
			return $this->permissionDenied();
		}*/ //! @todo Add this!
		
		// Get the image id from the request
		$imageid = $this->params('id');

		// Get the image from the database
		$imagesTable = $this->getServiceLocator()->get('GalleryImagesTable');
		$image = $imagesTable->getImage($imageid);
		
		// Check that a image was found
		if (!$image) {
			return $this->pageNotFound();
		}

		// Check that they are deleting their own image or have permission to delete other's images
		if ($image->userid != $user->userid) { // || !$this->hasPermission('gallery', 'delete-others')) {
			return $this->permissionDenied();
		} //! @todo Add this!

		// Create the form		
		$form = new DeletionConfirmationForm();
		$form->setAttribute('action', $this->url()->fromRoute('gallery/delete', $image->getCleanArrayCopy()));

		// Process POST requests
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			if ($request->getPost('accept') !== null) {
				if ($imagesTable->deleteImage($imageid)) {
					// Remove the photo from the disk
					if (file_exists('public/' . $image->thumbLocation)) {
						unlink('public/' . $image->thumbLocation);
					}
					
					if (file_exists('public/' . $image->imageLocation)) {
						unlink('public/' . $image->imageLocation);
					}
					
					$this->flashMessenger()->addSuccessMessage("Gallery image successfully deleted!");

					return $this->redirect()->toRoute('gallery');
				}

				$this->flashMessenger()->addErrorMessage("Gallery image could not be deleted!");
			}

			return $this->redirect()->toRoute('gallery/view', $image->getCleanArrayCopy());
		}

		// Display the form
		$view = new ViewModel(array(
			'form' => $form,
			'image' => $image
		));
		
		$view->setTemplate('gallery/delete');

		return $view;
	}
}
