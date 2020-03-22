<?php

namespace Core\ORM;

use Core\Connection\IConnection;
use Core\Connection\Result;
use Core\ORM\Field\Field;
use Core\ORM\Query\Create;
use Core\ORM\Query\DefaultProcessor;
use Core\ORM\Query\Delete;
use Core\ORM\Query\Drop;
use Core\ORM\Query\Insert;
use Core\ORM\Query\IProcessor;
use Core\ORM\Query\Query;
use Core\ORM\Query\Select;
use Core\ORM\Query\Update;

abstract class EntityManager
{
    protected $connection;
    protected $processor;
    protected $lastQueryString; // for Debugging purpose

    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $parameters
     * @return Result
     */
    public function get($parameters)
    {
        $query = new Select($this->getProcessor());
        $query->setTableName($this->getTableName());

        if (isset($parameters['select']) && is_array($parameters['select'])) {
            $query->setSelect($parameters['select']);
        }

        if (isset($parameters['where'])) {
            $query->setWhere($parameters['where']);
        }

        if (isset($parameters['order'])) {
            $query->setOrder(...$parameters['order']);
        }

        if (isset($parameters['limit'])) {
            $query->setLimit($parameters['limit']);
        }

        if (isset($parameters['offset'])) {
            $query->setOffset($parameters['offset']);
        }

        return $this->execute($query);
    }

    public function add(array $data)
    {
        $this->checkFields($data);

        $query = new Insert($this->getProcessor());
        $query->setTableName($this->getTableName());
        $query->setData($data);

        return $this->execute($query);
    }

    public function update($primary, array $data)
    {
        $primaryField = $this->findPrimaryField();
        if ($primaryField === null) {
            throw new \RuntimeException('Failed to perform operation: undefined primary field.');
        }

        $search = array(
            $primaryField->getName(),
            $primary
        );

        $query = new Update($this->getProcessor());
        $query->setTableName($this->getTableName());
        $query->setData($data);
        $query->setWhere(array($search));

        return $this->execute($query);
    }

    public function delete($primary)
    {
        $primaryField = $this->findPrimaryField();
        if ($primaryField === null) {
            throw new \RuntimeException('Failed to perform operation: undefined primary field.');
        }
        $search = array(
            $primaryField->getName(),
            $primary
        );

        $query = new Delete($this->getProcessor());
        $query->setTableName($this->getTableName());
        $query->setWhere(array($search));

        return $this->execute($query);
    }

    public function create()
    {
        $query = new Create($this->getProcessor());
        $query->setTableName($this->getTableName());
        $query->setFields($this->getMap());

        return $this->execute($query);
    }

    public function drop()
    {
        $query = new Drop($this->getProcessor());
        $query->setTableName($this->getTableName());

        return $this->execute($query);
    }

    public function count($where)
    {
        $parameters = array(
            'select' => array('COUNT(1) AS `CNT`'),
            'where' => $where
        );

        $res = $this->get($parameters)->fetch();
        return $res['CNT'];
    }

    protected function execute(Query $query)
    {
        $queryString = $query->build();
        $this->lastQueryString = $queryString;

        return $this->connection->query($queryString);
    }

    protected function checkFields(array $data)
    {
        foreach ($this->getMap() as $field) {
            $fieldName = $field->getName();

            if (!isset($data[$fieldName])) {
                if ($field->isRequired() || ($field->isPrimary() && !$field->isAutoincrement())) {
                    throw new \RuntimeException('Required field "' . $fieldName . '" is empty.');
                }
            }
        }
    }

    /**
     * Обходит массив полей и находит PRIMARY KEY, если он есть.
     *
     * @return null|Field
     */
    protected function findPrimaryField()
    {
        foreach ($this->getMap() as $field) {
            if ($field->isPrimary()) {
                return $field;
            }
        }

        return null;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getLastQuery()
    {
        return $this->lastQueryString;
    }

    public function getProcessor()
    {
        if ($this->processor === null) {
            $this->processor = new DefaultProcessor($this->connection);
        }

        return $this->processor;
    }

    public function setProcessor(IProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Возвращает описание сущности в виде массива полей.
     *
     * @return Field[]
     */
    abstract public function getMap();

    abstract public function getTableName();
}