<?php
namespace Core\ORM\Query;

abstract class Query
{
    protected $tableName;
    protected $processor;

    public function __construct(IProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function setTableName(string $tableName)
    {
        $this->tableName = $this->processor->quote($tableName);
    }

    abstract public function build();
}