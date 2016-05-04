<?php

namespace Gallery\Controller;

use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Filter\File\RenameUpload;

use Core\Controller\AbstractActionController;

use Gallery\Db\GalleryTable;
use Gallery\Model\Gallery;

class ViewController extends AbstractActionController
{
	public function indexAction()
	{
		// Check if the user has permission to this action
		if (!$this->hasPermission('gallery', 'view')) {
			return $this->permissionDenied();
		}
		
		// Get the posts from the database
		$imagesTable = $this->getServiceLocator()->get('GalleryImagesTable');
		$images = $imagesTable->fetchAll();
		
		//! @todo Paginate this!

		// Display the view
		$view = new ViewModel(array(
			'images' => $images
		));

		$view->setTemplate('gallery/index');

		return $view;
	}

	public function viewAction()
	{
		// Check if the user has permission to this action
		if (!$this->hasPermission('gallery', 'view')) {
			return $this->permissionDenied();
		}
		
		// Get the image id from the request
		$imageid = $this->params('id');

		// Get the image from the database
		$imagesTable = $this->getServiceLocator()->get('GalleryImagesTable');
		$image = $imagesTable->getImage($imageid);
		
		// Check that an image was found
		if (!$image) {
			return $this->pageNotFound();
		}
    
		$commentTable = $this->getServiceLocator()->get('GalleryImageCommentsTable');
		$comments = $commentTable->getImageComments($image->id);
		
		// Display the view
		$view = new ViewModel(array(
			'image' => $image,
			'comments' => $comments
		));

		$view->setTemplate('gallery/view');

		return $view;
	}
}
