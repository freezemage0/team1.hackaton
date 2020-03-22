<?php
namespace User\Controller;

use Core\Controller\ControllerException;
use Core\Controller\StubController;
use Core\View\JsonView;
use Core\View\WebView;
use User\Service\UserService;

class UserController extends StubController
{
    protected $service;

    public function __construct(UserService $service)
    {
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

            $result = array(
                'result' => 'success',
                'message' => 'User registered successfully.'
            );
        } catch (\Exception $exception) {
            $result = array(
                'result' => 'error',
                'message' => $exception->getMessage()
            );
        }

        $jsonView = new JsonView();
        $jsonView->setData($result);
        return $jsonView;
    }

    public function logoutAction()
    {

    }

    public function authorizeAction()
    {
        if ($this->isSubmitted()) {
            $login = $this->request->get('LOGIN');
            $password = $this->request->get('PASSWORD');

            $this->service->authorize($login, $password);
        }
        $webView = new WebView();
        $webView->setTemplatePath('templates/user/authorize.php');
        return $webView;
    }

    protected function isSubmitted()
    {
        return $this->request->get('SUBMITTED') === 'Y';
    }

    public function testAction()
    {
        $jsonView = new JsonView();
        $jsonView->setData(array('UserController output' => 'test'));
        return $jsonView;
    }
}