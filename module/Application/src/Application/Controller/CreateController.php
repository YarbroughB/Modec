<?php
namespace Application\Controller;
 
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\CreateForm;
use Application\Form\Filter\CreateFilter;
use Application\Model\UserPassword;

class CreateController extends AbstractActionController {
	
	protected $storage;
	protected $authservice;
	
	public function indexAction(){       
		$request = $this->getRequest();
		
		$view = new ViewModel();
		$createForm = new CreateForm('createForm');       
		$createForm->setInputFilter(new CreateFilter());
		
		if($request->isPost()){
			$data = $request->getPost();
			$createForm->setData($data);
			
			if($createForm->isValid()){
				$data = $createForm->getData();
				if($this->getDatabase()->userExists($data['username']))
				{
					$createForm->get('username')->setMessages(array('Username is taken.'));
				}
				else
				{
					//add user to db
					$this->getDatabase()->saveUser($data);
					//redirect to login page
					return $this->redirect()->tourl('/application/login');
				}				
			}
			else{
				$errors = $createForm->getMessages(); 
			}
		}
		
		$view->setVariable('createForm', $createForm);
		return $view;
	}
	
	public function loginAction()
	{
		return $this->redirect()->tourl('/application/login');
	}
	
	private function getAuthService()
	{
		if (! $this->authservice) {
			$this->authservice = $this->getServiceLocator()->get('AuthService');
		}
		return $this->authservice;
	}
	
	private function getDatabase()
    {
        if (!$this->storage) {
            $sm = $this->getServiceLocator();
            $this->storage = $sm->get('Application\Model\DataAccess');
        }
        return $this->storage;
    }
}
?>	