<?php
namespace Core;

class Route
{
    protected $controller;
    protected $action;

    public function __construct(array $route)
    {
        $this->controller = $route['controller'] ?? null;
        $this->action = $route['action'] ?? null;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getMethodName(): string
    {
        return $this->getAction() . 'Action';
    }
}