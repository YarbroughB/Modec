<?php

namespace Core\Model;

class UsersTable extends AbstractTable
{
	public function getGroup($groupid)
	{
		$rowset = $this->tableGateway->select(array('id' => (int) $groupid));
		return $rowset->current();
	}
}