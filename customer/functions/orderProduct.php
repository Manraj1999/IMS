<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Customer.php';

    session_start();

    $Customer = new Customer();

    if(isset($_POST["Company_ID"]) && isset($_POST["Product_ID"]) && isset($_POST["Product_Quantity"]) && isset($_POST["Product_Price"]) && isset($_POST["Customer_Name"])) {
        $Customer->order($_POST["Company_ID"], $_POST["Product_ID"], $_POST["Product_Quantity"], $_POST["Product_Price"], $_POST["Customer_Name"]);
    } else {
        echo 0;
    }