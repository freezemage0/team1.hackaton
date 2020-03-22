<?php
namespace User\Controller;

use Core\Controller\StubController;
use Core\View\JsonView;

class UserController extends StubController
{
    public function registerAction()
    {

    }

    public function logoutAction()
    {

    }

    public function loginAction()
    {

    }

    public function testAction()
    {
        $jsonView = new JsonView();
        $jsonView->setData(array('UserController output' => 'test'));
        return $jsonView;
    }
}