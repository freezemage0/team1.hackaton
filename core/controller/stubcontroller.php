<?php
namespace Core\Controller;

use Core\Utility\Request;

abstract class StubController
{
    protected $action;
    /** @var Request $request */
    protected $request;

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setAction(string $action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     * @throws ControllerException
     */
    public function execute()
    {
        $reflection = new \ReflectionObject($this);
        $methodName = $this->action . 'Action';

        if (!$reflection->hasMethod($methodName)) {
            throw new ControllerException('Failed to execute method: malformed action name.');
        }

        try {
            $method = $reflection->getMethod($methodName);
            $result = $method->invoke($this);
            return $result;

        } catch (\Exception $exception) {
            throw new ControllerException('Failed to execute action because of exception', null, $exception);
        }
    }
}