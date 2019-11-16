<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Users.php';

    session_start();

    $Users = new Users();

    if(isset($_POST["User_ID"])) {
        $Users->passOwnership($_POST["User_ID"]);
    }