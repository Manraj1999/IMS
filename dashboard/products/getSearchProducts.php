<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Products.php';

    session_start();

    $Products = new Products();

    if(isset($_POST["searchData"])) {
        if(!empty($_POST['searchData'])) {
            $Products->getSearchProducts($_POST["searchData"]);
        } else {
            $Products->getProducts(10);
        }
    } else {
        $Products->getProducts(10);
    }