<?php
namespace Core\ORM\Query;

class Insert extends Query
{
    protected $columns;
    protected $values;

    public function setData(array $data)
    {
        foreach ($data as $column => $value) {
            $this->columns[] = $this->processor->quote($column);
            $this->values[] = $this->processor->prepare($value);
        }
    }

    public function build()
    {
        $query = array(
            'INSERT INTO',
            $this->tableName,
            '(' . implode(', ', $this->columns) . ')',
            'VALUES',
            '(' . implode(', ', $this->values) . ')'
        );

        return implode(' ', $query);
    }
}