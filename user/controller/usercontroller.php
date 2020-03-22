<?php
namespace User\Controller;

use Core\Controller\ControllerException;
use Core\Controller\StubController;
use Core\View\JsonView;
use Core\View\WebView;

class UserController extends StubController
{
    public function registerAction()
    {
        try {
            if (!$this->request->isPost()) {
                throw new ControllerException('Invalid request method.');
            }

            $login = $this->request->get('LOGIN');
            $password = $this->request->get('PASSWORD');
            $confirm = $this->request->get('CONFIRM');

            if ($password !== $confirm) {
                throw new ControllerException('Password and Confirm password do not match.');
            }

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
        $webView = new WebView();
        $webView->setTemplatePath('templates/user/authorize.php');
        return $webView;
    }

    public function testAction()
    {
        $jsonView = new JsonView();
        $jsonView->setData(array('UserController output' => 'test'));
        return $jsonView;
    }
}