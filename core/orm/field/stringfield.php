<?php
namespace ORM\Field;

class StringField extends Field
{
    protected const DEFAULT_LENGTH = 256;

    protected $length;

    public function getType()
    {
        return 'varchar';
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
     *
     * @return StringField
     */
    public function setLength(int $length)
    {
        $this->length = $length;
        return $this;
    }

    public function getColumnDescription()
    {
        return $this->getType() . '(' . $this->getLength() . ')';
    }


}