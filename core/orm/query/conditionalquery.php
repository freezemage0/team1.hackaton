<?php
namespace Core\ORM\Query;

use Core\ORM\Condition\ConditionBuilder;

abstract class ConditionalQuery extends Query
{
    protected $where;

    public function setWhere(array $conditions)
    {
        $conditionBuilder = new ConditionBuilder($this->processor);

        foreach ($conditions as $condition) {
            $conditionBuilder->addToChain($condition);
        }

        $this->where = $conditionBuilder->build();
    }
}