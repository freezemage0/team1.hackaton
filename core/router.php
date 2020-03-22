<?php
namespace Core;

use Core\Utility\Uri;
use Core\Utility\Request;

class Router
{
    protected const ROUTES_DEFAULT_FILENAME = 'routes.php';

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     * @throws RouterException
     */
    public function resolveRoute()
    {
        $uri = new Uri($this->request->getRequestedPath());
        $path = $uri->getPath();

        $parts = explode('/', $path);
        $moduleName = array_shift($parts);
        $methodName = array_shift($parts);

        if ($moduleName === null || $methodName === null) {
            throw new RouterException('Failed to resolve route: malformed path.');
        }

        $routeFile = array(
            $this->request->getDocumentRoot(),
            $moduleName,
            static::ROUTES_DEFAULT_FILENAME
        );

        $routeFile = implode('/', $routeFile);
        if (!is_file($routeFile)) {
            throw new RouterException("Failed to resolve route: routing for module '{$moduleName}' not found.");
        }

        $routes = include $routeFile;
        foreach ($routes as $controller => $action) {
            if ($action === $methodName) {
                return array('controller' => $controller, 'action' => $action);
            }
        }
        throw new RouterException('Failed to resolve route: undefined route.');
    }
}