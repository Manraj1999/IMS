<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Stores.php';

    session_start();

    $Stores = new Stores();

    if(isset($_POST['storeCode'])) {
        $Stores->getProductsForSpecificStore($_POST['storeCode']);
    }