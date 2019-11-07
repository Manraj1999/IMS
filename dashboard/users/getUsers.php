<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Users.php';

    session_start();

    $Users = new Users();

    $Users->getUsers();