<?php

namespace Gallery\Model;

use Core\Model\AbstractModel;

class GalleryImage extends AbstractModel
{
	protected $id;
	protected $userid;
	protected $username;
	protected $title;
	protected $description;
	protected $extension;
	protected $date;
	protected $editDate;
	protected $editUserid;
	protected $editUsername;
	
	protected function getCleanTitle()
	{
		return $this->cleanString($this->title);
	}
	
	static public function galleryPath()
	{
		//! @todo This path should come from a setting!
		return 'img/gallery/';
	}
	
	public function getThumbLocation()
	{
		//! @todo Make thumbnails actually be a thing!
		return $this->galleryPath() . $this->id . '.' . $this->extension;
	}
	
	public function getImageLocation()
	{
		//! @todo This path should come from a setting!
		return $this->galleryPath() . $this->id . '.' . $this->extension;
	}
}
