<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Stores.php';

    session_start();

    $Stores = new Stores();
    $Stores->getStores();