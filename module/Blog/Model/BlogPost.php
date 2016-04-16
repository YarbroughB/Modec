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
	
	public function maxBriefLength()
	{
		//! @todo This value should come from a setting!
		return 500;
	}
	
	public function textExceedsBrief()
	{
		return (strlen($this->text) > $this->maxBriefLength());
	}

	public function getBriefText()
	{
		if (strlen($this->text) < $this->maxBriefLength()) {
			return $this->text;
		}
		
		return substr($this->text, 0, $this->maxBriefLength() - 3) . '...';
	}
	
	protected function getCleanTitle()
	{
		return $this->cleanString($this->title);
	}
}
