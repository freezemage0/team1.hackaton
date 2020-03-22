<?php

use User\Controller\UserController;

return array(
    UserController::class => array(
        'authorize',
        'logout',
        'register'
    )
);