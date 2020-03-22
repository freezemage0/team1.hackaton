<?php
namespace ORM\Condition;

use ORM\Buildable;
use ORM\Query\IProcessor;

class ConditionBuilder implements Buildable
{
    protected $processor;
    protected $chain;
    protected $lastChainElement;

    public function __construct(IProcessor $processor)
    {
        $this->processor = $processor;
        $this->chain = array();
    }

    public function addToChain($item)
    {
        $chainItem = null;

        if (is_array($item)) {
            $chainItem = $this->addExpressionToChain(...$item);
        }

        if (Logic::isLogical($item)) {
            $chainItem = $this->addLogicToChain($item);
        }

        $this->lastChainElement = $chainItem;
        return $this;
    }

    public function addExpressionToChain($column, $value, $operator = '=')
    {
        $column = $this->processor->quote($column);
        $value = $this->processor->prepare($value);

        $expression = new Expression($column, $value, $operator);

        if ($this->lastChainElement instanceof Expression) {
            $this->chain[] = new Logic();
        }

        return $this->chain[] = $expression;
    }

    public function addLogicToChain($operator)
    {
        $logic = new Logic($operator);

        if ($this->lastChainElement instanceof Logic) {
            throw new \LogicException('Cannot add two consecutive logic elements to chain');
        }

        return $this->chain[] = $logic;
    }

    public function build()
    {
        $chain = array();

        foreach ($this->chain as $element) {
            $chain[] = $element->build();
        }

        return implode(' ', $chain);
    }
}