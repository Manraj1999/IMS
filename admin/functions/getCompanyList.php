<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Admin.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';

    $Admin = new Admin();

    $Admin->getCompanyList();