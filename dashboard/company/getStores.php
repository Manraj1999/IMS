<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Company.php';

    session_start();

    $Company = new Company();
    $Company->getStores();