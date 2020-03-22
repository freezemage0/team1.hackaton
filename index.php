<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

use Core\Connection\IConnection;
use Core\Connection\IConnectionConfiguration;
use Core\Connection\MysqliConfig;
use Core\Connection\MysqliConnection;
use Core\Controller\StubController;
use Core\DependencyInjection\Container;
use Core\Router;
use Core\Security\CurrentUser;
use Core\Utility\Debug;
use Core\Utility\Request;
use Core\View\IView;

require_once $_SERVER['DOCUMENT_ROOT'] . '/core/utility/loader.php';

try {
    $container = new Container();

    $container->alias(IConnectionConfiguration::class, MysqliConfig::class);
    $container->alias(IConnection::class, MysqliConnection::class);
    $container->share(IConnection::class);

    $connection = $container->get(IConnection::class);
    $connection->connect($container->get(IConnectionConfiguration::class));

    /** @var Router $router */
    $router = $container->get(Router::class);
    $route = $router->resolveRoute();

    $container->share(CurrentUser::class);
    $container->alias(StubController::class, $route->getController());

    /** @var StubController $controller */
    $controller = $container->get(StubController::class);
    $controller->setRequest($container->get(Request::class));

    $view = $controller->execute($route);

    if (!($view instanceof IView)) {
        throw new \Core\Controller\ControllerException('Wrong controller return type.');
    }
    $view->render();

} catch (\Exception $exception) {
    Debug::dump($exception->getMessage());
}

