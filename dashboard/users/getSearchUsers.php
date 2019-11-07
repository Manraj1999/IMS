<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Users.php';

    session_start();

    $Users = new Users();

    if(isset($_POST["searchData"])) {
        if(!empty($_POST['searchData'])) {
            $Users->getUsersWithSearch($_POST["searchData"]);
        } else {
            $Users->getUsers();
        }
    } else {
        $Users->getUsers();
    }