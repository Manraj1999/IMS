<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/DatabaseHandler.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/modals/UserModal.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/modals/CompanyModal.php";

class DashboardHome {

    function getCurrentWeekOrderCount() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $count = 0;

        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $getOrderSQL = "SELECT * FROM orders WHERE Order_Date > DATE_SUB(NOW(), INTERVAL 1 WEEK)";
        $getOrderResult = $connection->query($getOrderSQL);

        if($getOrderResult->num_rows > 0) {
            while($row = $getOrderResult->fetch_assoc()) {
                $count++;
            }
        }

        return $count;
    }

    function checkForAlerts() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();
        $CompanyModal = new CompanyModal();

        $alert["msg"] = "";
        $alert["bool"] = false;
        $alert["count"] = 0;

        $minThreshold = $CompanyModal->getCompanyData("Minimum_Threshold");
        $maxThreshold = $CompanyModal->getCompanyData("Maximum_Threshold");

        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $getOrderSQL = "SELECT * FROM products";
        $getOrderResult = $connection->query($getOrderSQL);

        if($getOrderResult->num_rows > 0) {
            while($row = $getOrderResult->fetch_assoc()) {
                if($row["Product_Inventory"] < $minThreshold) {
                    $alert["msg"] .= $row["Product_Name"] . " is currently below the minimum threshold at " . $row["Product_Inventory"] . " items remaining.</br>";
                    $alert["bool"] = true;
                    $alert["count"]++;
                }
                if($row["Product_Inventory"] > $maxThreshold) {
                    $alert["msg"] .= $row["Product_Name"] . " is currently above the maximum threshold at " . $row["Product_Inventory"] . " items.</br>";
                    $alert["bool"] = true;
                    $alert["count"]++;
                }
            }

            if(!($alert["bool"])) {
                $alert["msg"] = "There are no alerts at the moment.";
                $alert["bool"] = false;
                $alert["count"] = 0;
            }

        } else {
            $alert["msg"] = "There are no alerts at the moment.";
            $alert["bool"] = false;
            $alert["count"] = 0;
        }

        return $alert;
    }

    function getOrdersDataByMonth() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $count = 0;

        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $getOrderSQL = "SELECT * FROM orders WHERE Order_Date > MONTH('')";
        $getOrderResult = $connection->query($getOrderSQL);

        if($getOrderResult->num_rows > 0) {
            while($row = $getOrderResult->fetch_assoc()) {
                $count++;
            }
        }

        return $count;
    }

}