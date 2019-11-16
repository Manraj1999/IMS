<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Settings.php';

    session_start();

    $Settings = new Settings();

    if(isset($_POST["Format"])) {
        $Settings->saveCurrencyFormat($_POST["Format"]);
    }