<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Categories.php';

    session_start();

    $Categories = new Categories();
    $Categories->getCategories();