<?php
namespace Chat\Service;

use Chat\Entity\ChatManager;
use Core\Connection\Persistence\TransactionManager;
use Core\Security\CurrentUser;

class ChatService
{
    protected $manager;
    protected $user;

    public function __construct(CurrentUser $user, ChatManager $manager)
    {
        $this->user = $user;
        $this->manager = $manager;
    }

    public function send($messageText)
    {
        $transactionManager = $this->getTransactionManager();

        $callable = function ($messageText) {
            $userId = $this->user->getId();
            $timestamp = time();

            $this->manager->add(array(
                'USER_ID' => $userId,
                'MESSAGE_TEXT' => $messageText,
                'MESSAGE_TIMESTAMP' => $timestamp
            ));

        };

        return $transactionManager->wrap($callable, array('messageText' => $messageText));
    }

    public function getHistory($offset = 0)
    {
        $transactionManager = $this->getTransactionManager();

        $callable = function ($offset) {
            $userId = $this->user->getId();

            $dbMessages = $this->manager->get(array(
                'offset' => ($offset * 50),
                'order' => array('MESSAGE_TIMESTAMP', 'DESC'),
                'limit' => 50,
                'where' => array(
                    array('USER_ID', $userId)
                )
            ));

            $messages = array();
            $lastMessageId = null;
            while ($message = $dbMessages->fetch()) {
                if ($lastMessageId === null) {
                    $lastMessageId = $message['ID'];
                }
                $messages[] = $message;
            }

            $this->user->getSession()->set('LAST_MESSAGE_ID', $lastMessageId);
            return $messages;
        };

        return $transactionManager->wrap($callable, array('offset' => $offset));
    }

    public function getNewMessages()
    {
        $transactionManager = $this->getTransactionManager();

        $callable = function () {
            $lastMessageId = $this->user->getSession()->get('LAST_MESSAGE_ID');

            $dbMessages = $this->manager->get(
                array(
                    'where' => array(
                        array('ID', $lastMessageId, '>')
                    ),
                    'order' => array('MESSAGE_TIMESTAMP' => 'DESC')
                )
            );

            $messages = array();
            $newLastMessageId = null;

            while ($message = $dbMessages->fetch()) {
                if ($newLastMessageId === null) {
                    $newLastMessageId = $message['ID'];
                }
                $messages[] = $message;
            }

            $this->user->getSession()->set('LAST_MESSAGE_ID', $newLastMessageId);
            return $messages;
        };

        $start = time();
        while ((time() - $start) < 25) {
            $newMessages = $transactionManager->wrap($callable, array());
            if (!empty($newMessages)) {

                return $newMessages;
            }
        }
        return array();
    }

    /**
     * @return TransactionManager
     */
    protected function getTransactionManager()
    {
        return $this->manager->getConnection()->getTransactionManager();
    }
}