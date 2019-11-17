<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';

class Customer {

    function getCompanyList() {
        $DatabaseHandler = new DatabaseHandler();

        $sql = "SELECT * FROM ims.company_list WHERE Status='APPROVED'";
        $connection = $DatabaseHandler->getAdminMySQLiConnection();

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo "<option value='" . $row["Company_ID"] . "'>" . $row["Company_Name"] . "</option>";
            }
        } else {
            echo "";
        }
    }

    function getProductsFromCompany($company_id) {
        echo "<option value='default' selected disabled hidden>Product Name</option>";

        $DatabaseHandler = new DatabaseHandler();
        $CompanyModal = new CompanyModal();

        $sql = "SELECT * FROM products";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($company_id);

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo "<option value='" . $row["Product_ID"] . "'>" . $row["Product_Name"] . " - " . $CompanyModal->getCompanyData("Currency_Format") . $row["Product_Price"] . "/pc</option>";
            }
        } else {
            echo "";
        }
    }

    function getNoProducts() {
        echo "<option value='default' selected disabled hidden>Company not selected</option>";
    }

    function getMaxInventoryForProduct($company_id ,$product_id) {
        $DatabaseHandler = new DatabaseHandler();

        $sql = "SELECT * FROM products WHERE Product_ID='$product_id'";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($company_id);

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo $row["Product_Inventory"];
            }
        } else {
            echo "";
        }
    }

    function getPrice($company_id ,$product_id, $product_quantity) {
        $DatabaseHandler = new DatabaseHandler();

        $sql = "SELECT * FROM products WHERE Product_ID='$product_id'";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($company_id);

        $results = $connection->query($sql);

        $price = 0;
        $total = 0;

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                $price = $row["Product_Price"];
            }

            $total = $price * $product_quantity;

            echo $total;
        } else {
            echo $total;
        }
    }

}