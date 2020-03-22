<?php
namespace Chat\Controller;

use Chat\Service\ChatService;
use Core\Controller\ControllerException;
use Core\Security\AuthController;
use Core\Security\CurrentUser;
use Core\View\JsonView;
use Core\View\WebView;

class ChatController extends AuthController
{
    protected $service;

    public function __construct(CurrentUser $user, ChatService $service)
    {
        $this->service = $service;
        parent::__construct($user);
    }

    public function indexAction()
    {
        $webView = new WebView();
        $webView->setTemplatePath('templates/chat/index.php');
        return $webView;
    }

    public function sendAction()
    {
        try {
            if (!$this->request->isPost()) {
                throw new ControllerException('Unsupported request method.');
            }

            $messageText = $this->request->get('MESSAGE_TEXT');

            $this->service->send($messageText);

            $result = array(
                'result' => 'success',
                'message' => 'Message added successfully.'
            );
        } catch (\Exception $exception) {
            $result = array(
                'result' => 'error',
                'message' => $exception->getMessage()
            );
        }

        $jsonView = new JsonView();
        $jsonView->setData($result);
        return $jsonView;
    }

    public function getHistoryAction()
    {
        try {
            if (!$this->request->isPost()) {
                throw new ControllerException('Unsupported request method.');
            }

            $offset = $this->request->get('OFFSET');

            $messages = $this->service->getHistory($offset);

            $result = array(
                'result' => 'success',
                'messages' => $messages
            );
        } catch (\Exception $exception) {
            $result = array(
                'result' => 'error',
                'message' => $exception->getMessage()
            );
        }

        $jsonView = new JsonView();
        $jsonView->setData($result);
        return $jsonView;
    }
}