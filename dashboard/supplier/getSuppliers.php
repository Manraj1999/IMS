<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Supplier.php';

    session_start();

    $Supplier = new Supplier();
    $Supplier->getSuppliers();