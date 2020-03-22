<?php

namespace User\Service;

use Core\Connection\MysqliConnection;
use Core\Security\CurrentUser;
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

    }

    public function addUser(array $parameters)
    {
        $transactionManager = $this->getTransactionManager();
        try {
            $transactionManager->startTransaction();
            $login = $parameters['LOGIN'];
            $password = $parameters['PASSWORD'];

            if ($this->loginAlreadyTaken($login)) {
                throw new \InvalidArgumentException('Failed to register new user: login already taken.');
            }

            $result = $this->manager->add($parameters);
            $transactionManager->commitTransaction();
            return $result;

        } catch (\Exception $exception) {
            $transactionManager->rollbackTransaction();
            throw $exception;
        }
    }

    public function getUsers(array $parameters = array())
    {
        $transactionManager = $this->getTransactionManager();

        $callable = function ($parameters) {
            /** @var \mysqli_result $dbUsers */
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
            $users = $this->getUsers(array('filter' => array('LOGIN', $login)));
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