<?php

namespace Gallery\Controller;

use Zend\View\Model\ViewModel;
use Gallery\Db\GalleryTable;
use Gallery\Model\Gallery;
use Core\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Filter\File\RenameUpload;

class GalleryController extends AbstractActionController
{
	protected $galleryTable;
	
	public function indexAction()
	{
		$view =  new ViewModel(array(
			'gallerys' => $this->getGalleryTable()->fetchAll(),
		));
		$view->setTemplate('gallery/index');
		return $view;
	}
	
	public function addAction()
	{
	  $user = $this->identity();
		if (!$user) {
			return $this->permissionDenied();
		}
		// Create the form		
		$form = new \Gallery\Form\GalleryForm();
		$form->setAttribute('action', $this->url()->fromRoute('gallery'));
		// Process POST requests
		$request = $this->getRequest();

    if ($request->isPost()) {
			// Setup the form data and input filter
			$nonFile = $request->getPost()->toArray();
			//Gets the file data from the form
			$filePost = $this->params()->fromFiles('location');
			$file = array('location' =>$filePost['tmp_name']);
			//merges file data and nonfile data
			$temp = array_merge_recursive(
				$this->getRequest()->getPost()->toArray(),
				$this->getRequest()->getFiles()->toArray()
			);
			$form->setData($temp);
			$form->setInputFilter(
				new \Gallery\Form\GalleryFilter($this->getServiceLocator())
			);
			// Check if the form is valid
			if ($form->isValid()) {
				$galleryTable = $this->getServiceLocator()->get('GalleryTable');
				//makes a new name for the photo being stored
				//! @todo Change to stop conflicts from multiple people uploading photo at the same time.
				$newName = $galleryTable->getPhotoId();
				//Gets extension for the name
				if(substr($filePost['name'], strlen($filePost['name'])-3) == 'png' ||
				   substr($filePost['name'], strlen($filePost['name'])-3) == 'jpg')
				{
				  $extension = substr($filePost['name'], strlen($filePost['name'])-3);
				}
				else
				{
					$extension = "jpeg";
				}
				//Stores the photo on the server
				$adapter = new \Zend\File\Transfer\Adapter\Http();
				$adapter->setDestination('public/img/gallery');
				$adapter->addFilter('File\Rename', array('target' => $adapter->getDestination().
				                    DIRECTORY_SEPARATOR . $newName.'.'.$extension,
														'overwrite' => true));
				if($adapter->receive($filePost['name'])) {
			    
				}
				else {
					$this->flashMessenger()->addSuccessMessage("Failed to upload file");
				}
				//Get the data from the form
				$data = $form->getData();
				$data['userid'] = $this->identity()->userid;
				$data['location'] = $adapter->getDestination().
				                    DIRECTORY_SEPARATOR . $newName.'.'.$extension;
				// Create the photo
				$gallery = new Gallery();
				$gallery->exchangeArray($data);
				
				// Add the photo to the database
				$galleryTable = $this->getServiceLocator()->get('GalleryTable');
				$galleryTable->savePhoto($gallery);
				
				// Update the gallery and redirect
				$this->flashMessenger()->addSuccessMessage("You have successfully posted a photo!");
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
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		//makes sure that photo exists
		if (!$id) {
			$this->flashMessenger()->addSuccessMessage("Unable to get photoId");
			return $this->redirect()->toRoute('gallery');
		}
		$user = (string) $this->identity() -> userid;
		$galleryUser = $this->getGalleryTable()->getGallery($id)->userid;
		//make sure that the user who owns this photo is logged in
		if($user == $galleryUser)
		{
			$request = $this->getRequest();
			if ($request->isPost()) {
				$del = $request->getPost('del', 'No');
				if ($del == 'Yes') {
					//Finds the location the image is stored
					$gallery = $this->getGalleryTable()->getGallery($id);
					$imageFile = $gallery->location;
					//deletes the database entry
					$this->getGalleryTable()->deleteGallery($id);
					//deletes the photo
					unlink($imageFile);
        }
        
				// Redirect to gallery/index.phtml
				$this->flashMessenger()->addSuccessMessage("You have successfully deleted $id");
        return $this->redirect()->toRoute('gallery');
      }

      $view = new ViewModel(array(
        'id'    => $id,
        'gallery' => $this->getGalleryTable()->getGallery($id)
      ));
			$view->setTemplate('gallery/delete');
			return $view;
		}
		else
		{
			return $this->permissionDenied();
		}
	}
	
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('gallery', array(
				'action' => 'add'
			));
		}
		$user = (int) $this->identity() -> userid;
		// Get the photo with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the index page.
		try {
			$gallery = $this->getGalleryTable()->getGallery($id);
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('gallery', array(
				'action' => 'index'
			));
		}
				 
		if($user == $gallery -> userid)
		{

			$form  = new \Gallery\Form\GalleryEditForm();
			$form->bind($gallery);
			$form->get('submit')->setAttribute('value', 'Edit');
			$request = $this->getRequest();
			if ($request->isPost()) {
				$form->setData($request->getPost());
				$form->setInputFilter(
					new \Gallery\Form\GalleryEditFilter($this->getServiceLocator())
				);
				if ($form->isValid()) {
					$this->getGalleryTable()->savePhoto($gallery);

					// Redirect to gallery/index.phtml
					$this->flashMessenger()->addSuccessMessage("You have successfully changed $id");
					return $this->redirect()->toRoute('gallery');
				}
			}

			$view = new ViewModel(array(
        'id'    => $id,
        'form' => $form,
      ));
			$view->setTemplate('gallery/edit');
			return $view;
		}
		else
		{
			return $this->permissionDenied();
		}
	}
	
	public function getGalleryTable()
  {
		if (!$this->galleryTable) {
			$sm = $this->getServiceLocator();
			$this->galleryTable = $sm->get('GalleryTable');
    }
    return $this->galleryTable;
  }
}