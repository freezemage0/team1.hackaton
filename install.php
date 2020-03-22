<?php

use Chat\Entity\ChatUserManager;
use Core\Connection\IConnection;
use Core\Connection\IConnectionConfiguration;
use Core\Connection\MysqliConfig;
use Core\Connection\MysqliConnection;
use User\Entity\UserManager;
use Core\DependencyInjection\Container;

require_once $_SERVER['DOCUMENT_ROOT'] . '/core/utility/loader.php';

$container = new Container();

$container->alias(IConnectionConfiguration::class, MysqliConfig::class);
$container->alias(IConnection::class, MysqliConnection::class);
$container->share(IConnection::class);

$connection = $container->get(IConnection::class);
$connection->connect($container->get(IConnectionConfiguration::class));

/** @var UserManager $manager */
$manager = $container->get(ChatUserManager::class);
$manager->create();