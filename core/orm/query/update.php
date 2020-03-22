<?php
namespace Core\ORM\Query;

class Update extends ConditionalQuery
{
    protected $values;

    public function setData(array $data)
    {
        foreach ($data as $column => $value) {
            $item = array(
                $this->processor->quote($column),
                '=',
                $this->processor->prepare($value)
            );

            $this->values[] = implode(' ', $item);
        }
    }

    public function build()
    {
        $query = array(
            'UPDATE' => $this->tableName,
            'SET' => implode(', ', $this->values)
        );

        if ($this->where !== null) {
            $query['WHERE'] = $this->where;
        }

        $result = array();
        foreach ($query as $option => $value) {
            $result[] = $option . ' ' . $value;
        }

        return implode(' ', $result);
    }
}