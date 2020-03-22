<?php
namespace Chat\Controller;

use Core\Controller\StubController;
use Core\View\WebView;

class ChatController extends StubController
{
    public function indexAction()
    {
        $webView = new WebView();
        $webView->setTemplatePath('templates/chat/index.php');
        return $webView;
    }
}