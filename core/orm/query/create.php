<?php
namespace Core\ORM\Query;

use Core\ORM\Field\Field;

class Create extends Query
{
    /** @var Field[] $fields */
    protected $fields;

    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function build()
    {
        $columns = array();

        foreach ($this->fields as $field) {
            $column = array(
                $this->processor->quote($field->getName()),
                $field->getColumnDescription()
            );
            if ($field->isRequired()) {
                $column[] = 'NOT NULL';
            }
            if ($field->isAutoincrement()) {
                $column[] = 'AUTO_INCREMENT';
            }
            if ($field->isPrimary()) {
                $column[] = 'PRIMARY KEY';
            }

            $columns[] = implode(' ', $column);
        }

        $columns = implode(', ', $columns);

        return sprintf('CREATE TABLE %s (%s)', $this->tableName, $columns);
    }
}