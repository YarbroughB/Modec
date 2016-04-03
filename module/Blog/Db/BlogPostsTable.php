<?php

namespace Blog\Db;

use Zend\Db\TableGateway\TableGateway;

use Core\Db\AbstractTable;

use Blog\Model\BlogPost;

class BlogPostsTable extends AbstractTable
{
	static protected $prefix  = 'blog_post';
	static protected $table   = 'blog_posts';
	static protected $columns = array(
		'id', 'userid', 'title', 'text'
	);

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
		
		return $this->insert($data);
	}

	public function updatePost(BlogPost $post)
	{
		return $this->update(
			$post->getArrayCopy(),
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
