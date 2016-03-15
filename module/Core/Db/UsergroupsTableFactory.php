<?php

namespace Core\Db;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

use Core\Model\Usergroup;
 
class UsersTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		// Get the db adapter
		$dbAdapter = $serviceLocator->get('DbAdapter');

		// Setup the result prototype
		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new Usergroup());

		// Create the table gateway
		$tableGateway = new TableGateway(
			'usergroups', $dbAdapter, null, $resultSetPrototype
		);

		// Return the table
		return new UsergroupsTable($tableGateway);
	}
}
