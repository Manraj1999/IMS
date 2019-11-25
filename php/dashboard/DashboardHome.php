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
                    $alert["msg"] .= "<span class='text-nowrap text-danger'>" . $row["Product_Name"] . " is currently below the minimum threshold at " . $row["Product_Inventory"] . " items remaining.</br></span>";
                    $alert["bool"] = true;
                    $alert["count"]++;
                }
                if($row["Product_Inventory"] > $maxThreshold) {
                    $alert["msg"] .= "<span class='text-nowrap text-danger'>" . $row["Product_Name"] . " is currently above the maximum threshold at " . $row["Product_Inventory"] . " items.</br></span>";
                    $alert["bool"] = true;
                    $alert["count"]++;
                }
            }

            if(!($alert["bool"])) {
                $alert["msg"] = "<span class='text-nowrap text-success'>There are no alerts at the moment.</span>";
                $alert["bool"] = false;
                $alert["count"] = 0;
            }

        } else {
            $alert["msg"] = "<span class='text-nowrap text-success'>There are no alerts at the moment.</span>";
            $alert["bool"] = false;
            $alert["count"] = 0;
        }

        return $alert;
    }

    function getOrdersCountDataByMonth($month, $year) {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $count = 0;

        // October 2019
        $octoberSQL = "SELECT * FROM orders WHERE DATE_FORMAT(Order_Date, '%m-%Y') = '$month-$year'";
        $octoberResult = $connection->query($octoberSQL);

        if($octoberResult->num_rows > 0) {
            while($row = $octoberResult->fetch_assoc()) {
                $count++;
            }
        }

        echo $count;
    }

    function getOrdersTotalDataByMonth($month, $year) {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $total = 0;

        // October 2019
        $octoberSQL = "SELECT * FROM orders WHERE DATE_FORMAT(Order_Date, '%m-%Y') = '$month-$year'";
        $octoberResult = $connection->query($octoberSQL);

        if($octoberResult->num_rows > 0) {
            while($row = $octoberResult->fetch_assoc()) {
                $total += $row["Total_Amount"];
            }
        }

        echo $total;
    }
}