<?php
namespace ORM\Field;

abstract class Field
{
    protected $name;
    protected $primary;
    protected $required;
    protected $autoincrement;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setPrimary(bool $primary)
    {
        $this->primary = $primary;
        return $this;
    }

    public function setRequired(bool $required)
    {
        $this->required = $required;
        return $this;
    }

    public function setAutoincrement(bool $autoincrement)
    {
        $this->autoincrement = $autoincrement;
        return $this;
    }

    public function isPrimary()
    {
        return $this->primary ?? false;
    }

    public function isRequired()
    {
        return $this->required ?? false;
    }

    public function isAutoincrement()
    {
        return $this->autoincrement ?? false;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    abstract public function getType();

    abstract public function getColumnDescription();
}