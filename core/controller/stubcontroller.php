<?php
namespace Core\Controller;

use Core\Route;
use Core\Utility\Request;
use Core\View\IView;

abstract class StubController
{
    protected $action;
    /** @var Request $request */
    protected $request;

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Route $route
     *
     * @return IView
     * @throws ControllerException
     */
    public function execute(Route $route): IView
    {
        $reflection = new \ReflectionObject($this);

        if (!$reflection->hasMethod($route->getMethodName())) {
            throw new ControllerException('Failed to execute method: malformed action name.');
        }

        try {
            $method = $reflection->getMethod($route->getMethodName());
            $result = $method->invoke($this);
            return $result;

        } catch (\Exception $exception) {
            throw new ControllerException('Failed to execute action because of exception', null, $exception);
        }
    }
}