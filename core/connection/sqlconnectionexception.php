<?php
namespace Core\Connection;

use Throwable;

class SqlConnectionException extends \Exception
{
    protected $connection;

    public function __construct($message = "", $code = 0, $connection = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->connection = $connection;
    }

    /**
     * @return IConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }
}