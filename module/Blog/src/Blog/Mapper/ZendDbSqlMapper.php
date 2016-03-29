<?php
 namespace Blog\Mapper;

 use Blog\Model\PostInterface;
 use Zend\Db\Adapter\AdapterInterface;
 use Zend\Db\Adapter\Driver\ResultInterface;
 use Zend\Db\ResultSet\HydratingResultSet;
 use Zend\Db\Sql\Delete;
 use Zend\Db\Sql\Insert;
 use Zend\Db\Sql\Sql;
 use Zend\Db\Sql\Update;
 use Zend\Stdlib\Hydrator\HydratorInterface;

 class ZendDbSqlMapper implements PostMapperInterface
 {
     protected $dbAdapter;
	 protected $hydrator;
     protected $postPrototype;
     public function __construct(AdapterInterface $dbAdapter,
         HydratorInterface $hydrator,
         PostInterface $postPrototype)
     {
         $this->dbAdapter      = $dbAdapter;
         $this->hydrator       = $hydrator;
         $this->postPrototype  = $postPrototype;
     }
     public function find($postid)
     {
		 $sql    = new Sql($this->dbAdapter);
         $select = $sql->select('posts');
         $select->where(array('postid = ?' => $postid));

         $stmt   = $sql->prepareStatementForSqlObject($select);
         $result = $stmt->execute();

         if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
             return $this->hydrator->hydrate($result->current(), $this->postPrototype);
         }

         throw new \InvalidArgumentException("Blog with given ID:{$postid} not found.");
     }
     public function findAll()
     {
		 $sql    = new Sql($this->dbAdapter);
         $select = $sql->select('posts');

         $stmt   = $sql->prepareStatementForSqlObject($select);
         $result = $stmt->execute();

         if ($result instanceof ResultInterface && $result->isQueryResult()) {
             $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

             return $resultSet->initialize($result);
         }

         return array();
     }
   public function save(PostInterface $postObject)
   {
      $postData = $this->hydrator->extract($postObject);
      unset($postData['postid']); //strip off id 

      if ($postObject->getPostid()) {
         $action = new Update('posts');
         $action->set($postData);
         $action->where(array('postid = ?' => $postObject->getPostid()));
      } else {
         $action = new Insert('posts');
         $action->values($postData);
      }

      $sql    = new Sql($this->dbAdapter);
      $stmt   = $sql->prepareStatementForSqlObject($action);
      $result = $stmt->execute();

      if ($result instanceof ResultInterface) {
         if ($newId = $result->getGeneratedValue()) {
            $postObject->setPostid($newId);
         }

         return $postObject;
      }

      throw new \Exception("Database error");
   }

     public function delete(PostInterface $postObject)
     {
         $action = new Delete('posts');
         $action->where(array('postid = ?' => $postObject->getPostid()));

         $sql    = new Sql($this->dbAdapter);
         $stmt   = $sql->prepareStatementForSqlObject($action);
         $result = $stmt->execute();

         return (bool)$result->getAffectedRows();
     }
 }