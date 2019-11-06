<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Products.php';

    session_start();

    $Products = new Products();

    if(isset($_POST['limitCount'])) {
        $Products->getProducts($_POST['limitCount']);
    } else {
        $Products->getProducts(10);
    }