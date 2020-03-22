<?php
namespace Core\Connection;

class MysqliConfig implements IConnectionConfiguration
{
    public function getHost()
    {
        return 'localhost';
    }

    public function getUsername()
    {
        return 'team1';
    }

    public function getPassword()
    {
        return "3FnxN,P49xDeH}'q";
    }

    public function getDatabaseName()
    {
        return 'team1_db';
    }
}