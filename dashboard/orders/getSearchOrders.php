<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Orders.php';

    session_start();

    $Orders = new Orders();

    if(isset($_POST["searchData"])) {
        if(!empty($_POST['searchData'])) {
            $Orders->getSearchOrders($_POST["searchData"]);
        } else {
            $Orders->getOrders();
        }
    } else {
        $Orders->getOrders();
    }