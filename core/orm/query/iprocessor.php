<?php
namespace Core\ORM\Query;

use Core\Connection\IConnection;

interface IProcessor
{
    /**
     * @see IConnection::quote()
     *
     * @param string $identifier
     * @return string
     */
    public function quote($identifier);

    /**
     * @see IConnection::prepare()
     *
     * @param string|int $value
     * @return string|int
     */
    public function prepare($value);
}