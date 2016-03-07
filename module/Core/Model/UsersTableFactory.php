<?php

namespace Core\Model;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

use Core\Model\User;
use Core\Model\UsersTable;
 
class UsersTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{	
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');

		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new User());

		$tableGateway = new TableGateway(
			'users', $dbAdapter, null, $resultSetPrototype
		);

		$table = new UsersTable($tableGateway);
		
		return $table;
	}
}
