<?php
namespace Core;

use Core\Utility\Debug;
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
     * @return Route
     * @throws RouterException
     */
    public function resolveRoute(): Route
    {
        $uri = new Uri($this->request->getRequestedPage());
        $path = trim($uri->getPath(), '/');


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
        foreach ($routes as $controller => $actions) {
            if (array_search($methodName, $actions) !== false) {
                return new Route(array('controller' => $controller, 'action' => $methodName));
            }
        }
        throw new RouterException('Failed to resolve route: undefined route.');
    }
}