<?php

namespace Core\Model;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

use Core\Model\NavigationElement;
use Core\Model\NavigationTable;
 
class NavigationTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		// Get the db adapter
		$dbAdapter = $serviceLocator->get('DbAdapter');

		// Setup the result prototype
		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new NavigationElement());

		// Create the table gateway
		$tableGateway = new TableGateway(
			'navigation', $dbAdapter, null, $resultSetPrototype
		);

		// Return the table
		return new NavigationTable($tableGateway);
	}
}
