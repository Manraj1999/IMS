<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Orders.php';

    session_start();

    $Orders = new Orders();
    $Orders->getOrders();