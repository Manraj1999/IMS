<?php
    include $_SERVER["DOCUMENT_ROOT"] . '/ims/php/user/User.php';

    session_start();

    $user = new User();
    $user->logout();