<?php
namespace Core\ORM\Field;

class IntegerField extends Field
{
    protected const DEFAULT_LENGTH = 11;

    protected $length;

    public function getType()
    {
        return 'int';
    }

    public function getColumnDescription()
    {
        return $this->getType() . '(' . $this->getLength() . ')';
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length ?? static::DEFAULT_LENGTH;
    }

    /**
     * @param int $length
     * @return IntegerField
     */
    public function setLength(int $length)
    {
        $this->length = $length;
        return $this;
    }
}