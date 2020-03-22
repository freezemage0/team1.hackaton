<?php
namespace Core\ORM\Condition;

use Core\ORM\Buildable;

class Expression implements Buildable
{
    protected $column;
    protected $value;
    protected $condition;

    public function __construct($column, $value, $condition = '=')
    {
        $this->column = $column;
        $this->value = $value;
        $this->condition = $condition;
    }

    public function build()
    {
        $expression = array(
            $this->column,
            $this->condition,
            $this->value
        );
        return implode(' ', $expression);
    }
}