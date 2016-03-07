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
		// Get the db adapter
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');

		// Setup the result prototype
		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new User());

		// Create the table gateway
		$tableGateway = new TableGateway(
			'users', $dbAdapter, null, $resultSetPrototype
		);

		// Return the table
		return new UsersTable($tableGateway);
	}
}
