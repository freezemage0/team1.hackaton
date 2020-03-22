<?php
namespace Chat\Entity;

use Core\ORM\EntityManager;
use Core\ORM\Field\Field;
use Core\ORM\Field\IntegerField;
use Core\ORM\Field\TextField;

class ChatManager extends EntityManager
{
    public function getMap()
    {
        return array(
            'ID' => (new IntegerField('ID'))->setAutoincrement(true)->setPrimary(true),
            'MESSAGE_TEXT' => (new TextField('MESSAGE_TEXT'))->setRequired(true),
            'MESSAGE_TIMESTAMP' => (new IntegerField('MESSAGE_TIMESTAMP'))->setLength(16),
            'USER_ID' => (new IntegerField('USER_ID'))->setRequired(true)
        );
    }

    public function getTableName()
    {
        return 'ht_chat';
    }
}