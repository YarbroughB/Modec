<?php

namespace Core\Db;

class UsergroupsTable extends AbstractTable
{
	static protected $table = 'usergroups';
	static protected $columns = array('id', 'title');

	public function getGroup($groupid)
	{
		$rowset = $this->select(array('id' => (int) $groupid));
		return $rowset->current();
	}
}