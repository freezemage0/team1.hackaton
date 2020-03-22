<?php
namespace Core\ORM\Field;

class TextField extends Field
{
    public function getType()
    {
        return 'text';
    }

    public function getColumnDescription()
    {
       return $this->getType();
    }

}