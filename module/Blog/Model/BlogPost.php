<?php

namespace Blog\Model;

use Core\Model\AbstractModel;

class BlogPost extends AbstractModel
{
	protected $id;
	protected $userid; 
	protected $title;
	protected $text;
	
	protected function getCleanTitle()
	{
		return $this->cleanString($this->title);
	}
}
