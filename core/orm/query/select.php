<?php
namespace Core\ORM\Query;

class Select extends ConditionalQuery
{
    protected $select;
    protected $limit;
    protected $offset;
    protected $orderColumn;
    protected $orderDirection;

    public function setSelect(array $columns)
    {
        foreach ($columns as $column) {
            $this->select = $this->processor->quote($column);
        }
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    public function setOffset(int $offset)
    {
        $this->offset = $offset;
    }

    public function setOrder($column, $direction)
    {
        $this->orderColumn = $this->processor->quote($column);
        $this->orderDirection = $direction;
    }

    protected function getOrderColumn()
    {
        return $this->orderColumn ?? 'ID';
    }

    protected function getOrderDirection()
    {
        return $this->orderDirection ?? 'ASC';
    }

    public function build()
    {
        $query = array(
            'SELECT' => implode(', ', $this->select) ?? '*',
            'FROM' => $this->tableName,
            'WHERE' => $this->where,
            'ORDER BY' => $this->getOrderColumn() . ' ' . $this->getOrderDirection(),
            'LIMIT' => $this->limit,
            'OFFSET' => $this->offset
        );

        $query = array_filter($query);

        if (empty($query['FROM'])) {
            throw new \RuntimeException('Failed to build select query: undefined table name');
        }

        if (isset($query['OFFSET']) && empty($query['LIMIT'])) {
            unset($query['OFFSET']);
        }

        $result = array();
        foreach ($query as $option => $value) {
            $result[] = $option . ' ' . $value;
        }

        return implode(' ', $result);
    }
}