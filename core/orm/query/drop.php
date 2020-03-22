<?php
namespace ORM\Query;

class Drop extends Query
{
    public function build()
    {
        return 'DROP TABLE ' . $this->tableName;
    }
}