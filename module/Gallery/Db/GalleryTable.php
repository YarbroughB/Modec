<?php

namespace Gallery\Db;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Db\Adapter;
use Zend\Db\ResultSet\ResultSet;


use Core\Db\AbstractTable;

use Gallery\Model\Gallery;

class GalleryTable extends AbstractTable
{
	static protected $table   = 'gallery';
	static protected $columns = array('photoId', 'userid', 'timestamp', 'description', 'location');
	
	protected $tableGateway;

	//Gets entire table
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
    return $resultSet;
	}
  
	//gets photo from gallery
	public function getGallery($photoId)
	{
		$photoId  = (int) $photoId;
		$rowset = $this->tableGateway->select(array('photoId' => $photoId));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $photoId");
		}
    return $row;
	}
  
	//saves photo into gallery
	public function savePhoto(Gallery $gallery)
	{
		$data = array(
		'userid' => $gallery->userid,
		'description'  => $gallery->description,
		'location' => $gallery->location,
		);
		$id = (int) $gallery->photoId;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getGallery($id)) {
				$this->tableGateway->update($data, array('photoId' => $id));
			} else {
				throw new \Exception('Gallery id does not exist');
			}
		}
	}
  
	//deletes photo from gallery
	public function deleteGallery($photoId)
	{
		$this->tableGateway->delete(array('photoId' => (int) $photoId));
	}
	
  //Currently gets the name of a new photo to be stored on server
	public function getPhotoId()
	{
		$rowset = $this->tableGateway->select();
		$size = $rowset->count();
		for($i = 0; $i <$size; $i++) {
			$rowset->next();
		}
		$row = $rowset->current();
		return $row->photoId + 1;
	}
}