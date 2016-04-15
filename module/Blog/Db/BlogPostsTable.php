<?php

namespace Blog\Db;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

use Core\Db\AbstractTable;
use Core\Db\UsersTable;

use Blog\Model\BlogPost;

class BlogPostsTable extends AbstractTable
{
	static protected $prefix  = 'blog_post';
	static protected $table   = 'blog_posts';
	static protected $columns = array(
		'id', 'userid', 'title', 'text', 'date', 'editDate', 'editUser'
	);

	protected function select($where = null)
	{
		$select = new Select();

		$select->from($this->getTable());

		// Add the post username join
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

	public function getPost($id)
	{
		$rowset = $this->select(array(
			'id' => (int) $id,
		));

		return $rowset->current();
	}

	public function addPost(BlogPost $post)
	{
		$data = $post->getArrayCopy();

		unset($data['id']);
		unset($data['username']);
		unset($data['editUsername']);
		
		return $this->insert($data);
	}

	public function updatePost(BlogPost $post)
	{
		$data = $post->getArrayCopy();

		unset($data['username']);
		unset($data['editUsername']);

		return $this->update(
			$data,
			array('id' => (int) $post->id)
		);
	}
	
	public function deletePost($id)
	{
		return $this->delete(array(
			'id' => (int) $id
		));
	}	
}
