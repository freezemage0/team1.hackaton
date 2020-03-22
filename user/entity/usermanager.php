<?php
namespace User\Entity;

use Core\ORM\EntityManager;
use Core\ORM\Field\Field;
use Core\ORM\Field\IntegerField;
use Core\ORM\Field\StringField;

class UserManager extends EntityManager
{
    public function getMap()
    {
        return array(
            'ID' => (new IntegerField('ID'))->setAutoincrement(true)->setPrimary(true),
            'LOGIN' => (new StringField('LOGIN'))->setRequired(true),
            'NAME' => (new StringField('NAME'))->setRequired(true),
            'PASSWORD' => (new StringField('PASSWORD'))->setRequired(true)
        );
    }

    public function getTableName()
    {
        return 'ht_user';
    }
}