<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Customer.php';

    session_start();

    $Customer = new Customer();

    if(isset($_POST["Company_ID"])) {
        $Customer->getProductsFromCompany($_POST["Company_ID"]);
    } else {
        $Customer->getNoProducts();
    }