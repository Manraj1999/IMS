<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Settings.php';

    session_start();

    $Settings = new Settings();

    $Settings->deleteEverything();