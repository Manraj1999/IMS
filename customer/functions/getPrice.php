<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Customer.php';

    session_start();

    $Customer = new Customer();

    if(isset($_POST["Company_ID"]) && isset($_POST["Product_ID"]) && isset($_POST["Product_Quantity"])) {
        $Customer->getPrice($_POST["Company_ID"], $_POST["Product_ID"], $_POST["Product_Quantity"]);
    } else {
        echo 0;
    }