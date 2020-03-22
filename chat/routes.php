<?php

use Chat\Controller\ChatController;

return array(
    ChatController::class => array(
        'index',
        'send',
        'getHistory',
        'getNewMessage'
    )
);
