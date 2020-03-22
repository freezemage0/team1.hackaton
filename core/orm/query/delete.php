<?php
namespace Core\ORM\Query;

class Delete extends ConditionalQuery
{
    public function build()
    {
        $query = array(
            'DELETE FROM' => $this->tableName,
            'WHERE' => $this->where
        );

        $result = array();
        foreach ($query as $option => $value) {
            $result[] = $option . ' ' . $value;
        }

        return implode(' ', $result);
    }
}