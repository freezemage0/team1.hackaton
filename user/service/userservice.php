<?php

namespace User\Service;

use Core\Connection\MysqliConnection;
use Core\Connection\Result;
use Core\Security\CurrentUser;
use Core\Utility\Debug;
use User\Entity\UserManager;

class UserService
{
    protected $user;
    protected $manager;

    public function __construct(CurrentUser $user, UserManager $manager)
    {
        $this->manager = $manager;
        $this->user = $user;
    }

    public function authorize($login, $password)
    {
        $transactionManager = $this->getTransactionManager();

        $callable = function ($login, $password) {
            $users = $this->manager->get(
                array(
                    'where' => array('LOGIN', $login)
                )
            );

            $user = $users->fetch();
            if ($user === false) {
                throw new \InvalidArgumentException('Invalid login or password.');
            }

            $hash = $user['PASSWORD'];
            if (!password_verify($password, $hash)) {
                throw new \InvalidArgumentException('Invalid login or password.');
            }

            $this->user->authorize($user['ID']);
        };

        return $transactionManager->wrap($callable, array('login' => $login, 'password' => $password));
    }

    public function addUser(array $parameters)
    {
        $transactionManager = $this->getTransactionManager();
        $callable = function ($login, $name, $password) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            if ($this->loginAlreadyTaken($login)) {
                throw new \InvalidArgumentException('Failed to register new user: login already taken.');
            }

            $result = $this->manager->add(
                array(
                    'LOGIN' => $login,
                    'PASSWORD' => $password,
                    'NAME' => $name
                )
            );

            return $result;
        };
        $transactionManager->wrap($callable, $parameters);
    }

    public function getUsers(array $parameters = array())
    {
        $transactionManager = $this->getTransactionManager();

        $callable = function ($parameters) {
            $dbUsers = $this->manager->get($parameters);
            $users = array();

            while ($user = $dbUsers->fetch()) {
                $users[] = $user;
            }
            return $users;
        };

        return $transactionManager->wrap($callable, $parameters);
    }

    public function loginAlreadyTaken($login)
    {
        $transactionManager = $this->getTransactionManager();
        $callable = function ($login) {
            $users = $this->manager->get(array('where' => array(array('LOGIN', $login))));
            return ($users->fetch() !== false);
        };

        return $transactionManager->wrap($callable, array('login' => $login));
    }

    protected function getTransactionManager()
    {
        /** @var MysqliConnection $connection */
        $connection = $this->manager->getConnection();
        return $connection->getTransactionManager();
    }
}