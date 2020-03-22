<?php
namespace Core\Security;

use Core\Controller\StubController;
use Core\Route;
use Core\View\IView;

abstract class AuthController extends StubController
{
    protected $user;

    public function __construct(CurrentUser $user)
    {
        $this->user = $user;
    }

    public function execute(Route $route): IView
    {
        if (!$this->user->isAuthorized()) {
            $this->request->redirect('/user/authorize/');
        }
        return parent::execute($route);
    }
}