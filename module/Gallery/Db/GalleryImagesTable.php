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

use Gallery\Model\GalleryImage;

class GalleryImagesTable extends AbstractTable
{
	static protected $prefix  = 'gallery_image';
	static protected $table   = 'gallery_images';
	static protected $columns = array(
		'id', 'userid', 'title', 'description', 'extension', 'date', 'editDate', 'editUserid'
	);

	protected function select($where = null)
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
	}
	
	public function getImage($id)
	{
		$rowset = $this->select(array(
			'id' => (int) $id,
		));

		return $rowset->current();
	}

	public function addImage(GalleryImage $image)
	{
		$data = $image->getArrayCopy();

		unset($data['id']);
		unset($data['username']);
		unset($data['editUsername']);
		
		return $this->insert($data);
	}

	public function updateImage(GalleryImage $image)
	{
		$data = $image->getArrayCopy();

		unset($data['username']);
		unset($data['editUsername']);

		return $this->update(
			$data,
			array('id' => (int) $image->id)
		);
	}
	
	public function deleteImage($id)
	{
		return $this->delete(array(
			'id' => (int) $id
		));
	}
}
