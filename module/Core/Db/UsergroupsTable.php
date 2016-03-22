<?php

namespace Core\Db;

class UsergroupsTable extends AbstractTable
{
	static protected $prefix  = 'usergroup';
	static protected $table   = 'usergroups';
	static protected $columns = array('id', 'title', 'type');

	//static protected $guestGroup;

	public function getGroup($groupid)
	{
		$rowset = $this->select(array('id' => (int) $groupid));
		return $rowset->current();
	}

	/*public function getGuestGroup()
	{
		if (!static::$guestGroup) {
			$rowset = $this->select(array('type' => 'GUEST'));
			static::$guestGroup = $rowset->current(); //! @note Assumes there is only one guest group!
		}
		
		return static::$guestGroup;
	}

	public function getGuestGroupId()
	{
		return $this->getGuestGroup()->id;
	}*/
}
