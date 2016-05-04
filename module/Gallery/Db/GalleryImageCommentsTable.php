<?php

namespace Gallery\Db;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

//use Zend\Db\Sql\Sql;
//use Zend\Db\Sql\Expression;
//use Zend\Db\Adapter;
//use Zend\Db\ResultSet\ResultSet;

use Core\Db\AbstractTable;
use Core\Db\UsersTable;

use Gallery\Model\GalleryImageComment;

class GalleryImageCommentsTable extends AbstractTable
{
	static protected $prefix  = 'gallery_comment';
	static protected $table   = 'gallery_comments';
	static protected $columns = array(
		'id', 'content', 'date', 'userid', 'imageid'
	);

	/*protected function select($where = null)
	{
		$select = new Select();

		$select->from($this->getTable());

		// Add the image username join
		$select->join(
			UsersTable::getTable(),
			$this->getTable() . '.userid = ' . UsersTable::getTable() . '.userid',
			'username'
		);

		// Add the edit username join
		$select->join(
			array('edit_user' => UsersTable::getTable()),
			$this->getTable() . '.editUserid = edit_user.userid',
			array('editUsername' => 'username'),
			'left'
		);

		// Add the where clause
		if ($where) {
			$select->where($where);
		}

		return parent::selectWith($select);
	}*/
	
	public function getComment($id)
	{
		$rowset = $this->select(array(
			'id' => (int) $id,
		));

		return $rowset->current();
	}
  
	public function getImageComments($imageid)
	{
		$rowset = $this->select(array(
		  'imageid' => (int) $imageid,
		));
		
		return $rowset;
	}
	
	public function addComment(GalleryImageComment $comment)
	{
		$data = $comment->getArrayCopy();

		unset($data['id']);
		unset($data['username']);
		
		return $this->insert($data);
	}

	public function updateComment(GalleryImageComment $comment)
	{
		$data = $comment->getArrayCopy();

		unset($data['username']);

		return $this->update(
			$data,
			array('id' => (int) $comment->id)
		);
	}
	
	public function deleteComment($id)
	{
		return $this->delete(array(
			'id' => (int) $id
		));
	}
}
