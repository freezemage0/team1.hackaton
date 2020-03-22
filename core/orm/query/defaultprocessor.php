<?php
namespace Core\ORM\Query;

use Core\Connection\IConnection;

class DefaultProcessor implements IProcessor
{
    protected $connection;

    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
    }

    public function quote($identifier)
    {
        return $this->connection->quote($identifier);
    }

    public function prepare($value)
    {
        return '"'.$this->connection->prepare($value).'"';
    }

}