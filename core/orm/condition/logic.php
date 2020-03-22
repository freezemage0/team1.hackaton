<?php
namespace Core\ORM\Condition;

use Core\ORM\Buildable;

class Logic implements Buildable
{
    public const LOGIC_AND = 'and';
    public const LOGIC_OR = 'or';

    protected $logic;

    public function __construct($operator = null)
    {
        $this->logic = $operator ?? static::LOGIC_AND;
    }

    public static function isLogical($string)
    {
        return ($string === self::LOGIC_AND) || ($string === self::LOGIC_OR);
    }

    public function build()
    {
        return $this->logic;
    }
}