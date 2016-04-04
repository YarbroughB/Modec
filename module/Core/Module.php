<?php

namespace Core;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Acl;
use Zend\View\Helper\Navigation;
use Zend\View\ViewEvent;
use Zend\View\Renderer\PhpRenderer;

use Core\Model\User;

class Module
{
	public function onBootstrap(MvcEvent $event)
	{
		// Check if the user is logged in
		$auth = new AuthenticationService();
		
		if ($user = $auth->getIdentity()) {
			// Grab the user's info from the db to ensure it's fresh
			$usersTable = $event->getApplication()->getServiceManager()->get('UsersTable');
			$user = $usersTable->getUser($user->userid);

			$storage = $auth->getStorage();
			$storage->write($user);
		}

		// Initialize the ACL	
		$this->initAcl($event, $user);
		
		// Configure the Format View Helpers
		$events = $event->getApplication()->getEventManager();
		$sharedEvents = $events->getSharedManager();

		$sharedEvents->attach('Zend\View\View', ViewEvent::EVENT_RENDERER_POST, function($event) {
			$renderer = $event->getRenderer();

			if ($renderer instanceof PhpRenderer) {
				$renderer->plugin("currencyFormat")->setCurrencyCode("USD")->setLocale('en_US');
				$renderer->plugin("dateFormat")->setTimezone("America/Chicago")->setLocale("en_US");
			}
		});
	}

	public function getConfig()
	{	
		return include __DIR__ . '/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__,
				),
			),
		);
	}

	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'AclResourcesTable' => 'Core\Db\AclResourcesTableFactory',
				'AclRulesTable'     => 'Core\Db\AclRulesTableFactory',
				'NavigationTable'   => 'Core\Db\NavigationTableFactory',
				'UsersTable'        => 'Core\Db\UsersTableFactory',
				'UsergroupsTable'   => 'Core\Db\UsergroupsTableFactory',
			),
		);
	}

	public function initAcl(MvcEvent $event, User $user = null)
	{
		// Create the ACL
		$acl = new Acl();
		
		// Add the roles
		$usergroupsTable = $event->getApplication()->getServiceManager()->get('UsergroupsTable');
		$usergroups = $usergroupsTable->fetchAll();
		
		foreach ($usergroups as $usergroup) {
			$acl->addRole($usergroup->id);
		}
		
		// Add the resources
		$resourcesTable = $event->getApplication()->getServiceManager()->get('AclResourcesTable');
		$resources = $resourcesTable->fetchAll();
		$skippedResources = array();
		
		while (!empty($resources)) {
			$resourceAdded = false;

			foreach ($resources as $resource) {
				if (isset($resource->parent) && !$acl->hasResource($resource->parent)) {
					$skippedResources[] = $resource;
					continue;
				}

				$acl->addResource($resource->id, $resource->parent);

				$resourceAdded = true;
			}
			
			if (!$resourceAdded) {
				throw new \Exception("Missing parent resource for one or more resources");
			}
			
			$resources = $skippedResources;
		}

		// Set the rules
		$rulesTable = $event->getApplication()->getServiceManager()->get('AclRulesTable');
		$rules = $rulesTable->fetchAll();
		

		foreach ($rules as $rule) {
			if ($rule->action == 'ALLOW') {
				$acl->allow($rule->usergroup, $rule->resource, $rule->privilege);
			} else if ($rule->action == 'DENY') {
				$acl->deny($rule->usergroup, $rule->resource, $rule->privilege);
			}
		}

		// Set the ACL in the view model
		$event->getViewModel()->acl = $acl;
		
		// Setup the navigation helper
		Navigation::setDefaultAcl($acl);

		if (!$user) {
			//$role = $usergroupsTable->getGuestGroupId();
			$role = '1'; // Guest
			//! @todo This should come from a setting of some kind!
		} else {
			$role = $user->usergroup->id;
		}
		
		Navigation::setDefaultRole($role);
	}
}
