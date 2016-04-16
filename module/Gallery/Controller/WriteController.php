<?php

namespace Gallery\Controller;

use Zend\View\Model\ViewModel;

use Core\Controller\AbstractActionController;

use Gallery\Form\GalleryImageForm;
use Gallery\Form\GalleryImageFilter;
use Gallery\Model\GalleryImage;

class WriteController extends AbstractActionController
{
	public function addAction()
	{
		// Check if the user has permission to this action
		$user = $this->identity();

		if (!$user || !$this->hasPermission('gallery', 'add')) {
			return $this->permissionDenied();
		}

		// Create the form		
		$form = new GalleryImageForm();
		$form->setAttribute('action', $this->url()->fromRoute('gallery/add'));
		
		// Process POST requests
		$request = $this->getRequest();

        if ($request->isPost()) {
			// Get the form data
			$post = $request->getPost()->toArray();
			$files = $request->getFiles()->toArray();
					
			// Setup the form data and input filter
			$form->setData(array_merge_recursive($post, $files));
			$form->setInputFilter(
				new GalleryImageFilter($this->getServiceLocator())
			);
			
			// Check if the form is valid
			if ($form->isValid()) {
				// Collect the image data
				$data = new GalleryImage($form->getData());

				$data->id     = null;
				$data->userid = $user->userid;
				$data->date   = time();

				$data->editUserid = null;
				$data->editDate   = null;
				
				// Find the image extension
				switch ($files['image']['type']) {
					case 'image/bmp':
						$data->extension = 'bmp';
						break;
					case 'image/gif':
						$data->extension = 'gif';
						break;
					case 'image/jpeg':
						$data->extension = 'jpg';
						break;
					case'image/png':
						$data->extension = 'png';
						break;
				}

				// Add the image to the database
				$imagesTable = $this->getServiceLocator()->get('GalleryImagesTable');
				$data->id = $imagesTable->addImage($data);
				
				// Save the image on the disc
				//! @todo Make image thumbnails!
				$adapter = new \Zend\File\Transfer\Adapter\Http();

				$adapter->setDestination('public/' . GalleryImage::galleryPath());
				$adapter->addFilter('File\Rename', array(
					'target' => $data->id . '.' . $data->extension
				));

				if ($adapter->receive($files['image']['name'])) {
					// Redirect the user to their newly made image
					return $this->redirect()->toRoute('gallery/view', $data->getCleanArrayCopy());
				}

				$this->flashMessenger()->addErrorMessage("Image upload failed, please try again later!");
				$imagesTable->deleteImage($data->id);
				
				return $this->redirect()->toRoute('gallery');
			}
		}

		// Display the form
		$view = new ViewModel(array(
			'form' => $form
		));
		
		$view->setTemplate('gallery/add');

		return $view;
	}

	public function editAction()
	{
		// Check if the user has permission to this action
		$user = $this->identity();

		if (!$user || !$this->hasPermission('gallery', 'edit')) {
			return $this->permissionDenied();
		}
		
		// Get the image id from the request
		$imageid = $this->params('id');

		// Get the image from the database
		$imagesTable = $this->getServiceLocator()->get('GalleryImagesTable');
		$image = $imagesTable->getImage($imageid);
		
		// Check that a image was found
		if (!$image) {
			return $this->pageNotFound();
		}

		// Check that they are editing their own image or have permission to edit other's images
		if ($image->userid != $user->userid && !$this->hasPermission('gallery', 'edit-others')) {
			return $this->permissionDenied();
		}

		// Create the form
		$form = new GalleryImageForm();
		$form->remove('image');

		$form->setAttribute('action', $this->url()->fromRoute('gallery/edit', $image->getCleanArrayCopy()));

		// Set the image data in the form
		$form->setData($image->getArrayCopy());

		// Process POST requests
		$request = $this->getRequest();

        if ($request->isPost()) {
			// Setup the form data and input filter
			$form->setData($request->getPost());
			
			$filter = new GalleryImageFilter($this->getServiceLocator());
			$filter->remove('image');

			$form->setInputFilter($filter);

			// Check if the form is valid
			if ($form->isValid()) {
				// Collect the image data
				$data = new GalleryImage($form->getData());

				$data->id     = $image->id;
				$data->userid = $image->userid;
				$data->date   = $image->date;

				$data->editUserid = $user->userid;
				$data->editDate   = time();

				$data->extension = $image->extension;

				// Add the image to the database
				$imagesTable = $this->getServiceLocator()->get('GalleryImagesTable');
				$imagesTable->updateImage($data);
				
				// Redirect the user to their newly made image
				return $this->redirect()->toRoute('gallery/view', $data->getCleanArrayCopy());
			}
		}

		// Display the form
		$view = new ViewModel(array(
			'image' => $image,
			'form' => $form
		));
		
		$view->setTemplate('gallery/edit');

		return $view;
	}
}
