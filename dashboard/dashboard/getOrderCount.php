<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/DashboardHome.php';

    session_start();

    $Dashboard = new DashboardHome();

    if(isset($_POST["month"]) && isset($_POST["year"])) {
        $Dashboard->getOrdersCountDataByMonth($_POST["month"], $_POST["year"]);
    } else {
        echo 0;
    }
