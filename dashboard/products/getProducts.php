<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Products.php';

    session_start();

    $Products = new Products();
    $Products->getProducts();