<?php
namespace Core\Connection\Persistence;

use Core\Connection\IConnection;

class TransactionManager
{
    public const STATE_OPEN = 0;
    public const STATE_CLOSED = 1;

    protected $connection;
    protected $state;

    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
        $this->state = static::STATE_CLOSED;
    }

    public function startTransaction()
    {
        if ($this->state === static::STATE_CLOSED) {
            $this->connection->startTransaction();
            $this->state = static::STATE_OPEN;
        }
    }

    public function commitTransaction()
    {
        if ($this->state === static::STATE_OPEN) {
            $this->connection->commitTransaction();
            $this->state = static::STATE_CLOSED;
        }
    }
    public function rollbackTransaction()
    {
        if ($this->state === static::STATE_OPEN) {
            $this->connection->rollbackTransaction();
            $this->state = static::STATE_CLOSED;
        }
    }

    public function wrap(callable $callable, array $parameters)
    {
        if ($this->state === static::STATE_OPEN) {
            return call_user_func_array($callable, $parameters);
        }

        try {
            $this->startTransaction();
            $result = call_user_func_array($callable, $parameters);
            $this->commitTransaction();

            return $result;
        } catch (\Exception $exception) {
            $this->rollbackTransaction();
            throw $exception;
        }
    }
}