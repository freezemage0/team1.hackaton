<?php
namespace User\Controller;

use Core\Controller\ControllerException;
use Core\Controller\StubController;
use Core\Security\CurrentUser;
use Core\View\JsonView;
use Core\View\RedirectView;
use Core\View\WebView;
use User\Service\UserService;

class UserController extends StubController
{
    protected $service;
    protected $user;

    public function __construct(CurrentUser $user, UserService $service)
    {
        $this->user = $user;
        $this->service = $service;
    }

    public function registerAction()
    {
        try {
            if (!$this->request->isPost()) {
                throw new ControllerException('Invalid request method.');
            }

            $login = $this->request->get('LOGIN');
            $name = $this->request->get('NAME');
            $password = $this->request->get('PASSWORD');
            $confirm = $this->request->get('CONFIRM');

            if ($password !== $confirm) {
                throw new ControllerException('Password and Confirm password do not match.');
            }

            $this->service->addUser(array(
                'LOGIN' => $login,
                'NAME' => $name,
                'PASSWORD' => $password
            ));

            $this->service->authorize($login, $password);
            $redirectView = new RedirectView();
            $redirectView->setLocation('/chat/index/');

            return $redirectView;
        } catch (\Exception $exception) {
            $result = array(
                'result' => 'error',
                'content' => $exception->getMessage()
            );

            $jsonView = new JsonView();
            $jsonView->setData($result);
            return $jsonView;
        }
    }

    public function logoutAction()
    {
        $this->user->logout();
        $redirectView = new RedirectView();
        $redirectView->setLocation('/user/authorize/');
        return $redirectView;
    }

    public function authorizeAction()
    {
        if (!$this->request->isPost()) {
            throw new ControllerException('Unsupported request method.');
        }
        if ($this->isSubmitted()) {
            $login = $this->request->get('LOGIN');
            $password = $this->request->get('PASSWORD');

            $this->service->authorize($login, $password);
        }
        if ($this->user->isAuthorized()) {
            $redirectView = new RedirectView();
            $redirectView->setLocation('/chat/index/');
            return $redirectView;
        }
        $webView = new WebView();
        $webView->setTemplatePath('templates/user/authorize.php');
        return $webView;
    }

    public function getUsersAction()
    {
        try {
            if (!$this->request->isPost()) {
                throw new ControllerException('Unsupported request method.');
            }
            if (!$this->user->isAuthorized()) {
                $redirectView = new RedirectView();
                $redirectView->setLocation('/user/authorize/');
                return $redirectView;
            }

            $users = $this->service->getUsers(array(
                'select' => array('ID', 'NAME', 'LOGIN')
            ));

            $result = array(
                'result' => 'success',
                'content' => $users
            );
        } catch (\Exception $exception) {
            $result = array(
                'result' => 'error',
                'content' => $exception->getMessage()
            );
        }

        $jsonView = new JsonView();
        $jsonView->setData($result);
        return $jsonView;
    }

    protected function isSubmitted()
    {
        return $this->request->get('SUBMITTED') === 'Y';
    }
}