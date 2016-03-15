<?php

namespace Core\Db;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

abstract class AbstractTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		// Setup the result prototype		
		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype($this->getModel());

		// Create the table gateway
		$tableGateway = new TableGateway(
			$this->getTable(),
			$serviceLocator->get('DbAdapter'),
			null,
			$resultSetPrototype
		);

		// Return the table
		return $this->createTable($tableGateway);
	}

	abstract protected function getTable();

	abstract protected function getModel();
	
	abstract protected function createTable(TableGateway $tableGateway);
}
