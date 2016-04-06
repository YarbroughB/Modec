<?php

namespace Blog\Model;

use Core\Model\AbstractModel;

class BlogPost extends AbstractModel
{
	protected $id;
	protected $userid;
	protected $username;
	protected $title;
	protected $text;
	protected $date;
	protected $editDate;
	protected $editUserid;
	protected $editUsername;
	
	protected function getCleanTitle()
	{
		return $this->cleanString($this->title);
	}
}
