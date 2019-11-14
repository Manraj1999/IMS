<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Admin.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';

    $Admin = new Admin();

    if(isset($_POST["List_ID"]) && isset($_POST["Status"])) {
        $Admin->updateStatus($_POST["List_ID"], $_POST["Status"]);
    }