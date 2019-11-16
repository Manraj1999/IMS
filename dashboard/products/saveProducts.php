<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';

session_start();

$DatabaseHandler = new DatabaseHandler();
$UserModal = new UserModal();
$CompanyModel = new CompanyModal();

$connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

$min_threshold = $CompanyModel->getCompanyData("Minimum_Threshold");
$max_threshold = $CompanyModel->getCompanyData("Maximum_Threshold");

if(!($min_threshold == NULL) && !($max_threshold == NULL)) {
    if($max_threshold >= $_POST["product_inventory"] && $_POST["product_inventory"] >= $min_threshold) {
        $sql = "INSERT INTO products(Supplier_Code, Store_Code, Product_Code, Product_Name, Product_Category, Product_Inventory, Product_Price) VALUES('".mysqli_real_escape_string($connect, $_POST["supplier_code"])."', '".mysqli_real_escape_string($connect, $_POST["store_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_name"])."', '".mysqli_real_escape_string($connect, $_POST["product_category"])."', '".mysqli_real_escape_string($connect, $_POST["product_inventory"])."', '".mysqli_real_escape_string($connect, $_POST["product_price"])."')";
        if($connect->query($sql)) {
            echo "Product [" . $_POST['product_name'] . "] has been added";
        } else {
            echo "Failed to add Product [" . $_POST['product_name'] . "]";
        }
    } else {
        if($_POST["product_inventory"] > $max_threshold) {
            echo "The entered inventory amount is above the maximum threshold. Consider changing it.";
        } elseif($min_threshold > $_POST["product_inventory"]) {
            echo "The entered inventory amount is below the minimum threshold. Consider changing it.";
        }
    }
} elseif(!($min_threshold == NULL)) {
    if($_POST["product_inventory"] >= $max_threshold) {
        $sql = "INSERT INTO products(Supplier_Code, Store_Code, Product_Code, Product_Name, Product_Category, Product_Inventory, Product_Price) VALUES('".mysqli_real_escape_string($connect, $_POST["supplier_code"])."', '".mysqli_real_escape_string($connect, $_POST["store_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_name"])."', '".mysqli_real_escape_string($connect, $_POST["product_category"])."', '".mysqli_real_escape_string($connect, $_POST["product_inventory"])."', '".mysqli_real_escape_string($connect, $_POST["product_price"])."')";
        if($connect->query($sql)) {
            echo "Product [" . $_POST['product_name'] . "] has been added";
        } else {
            echo "Failed to add Product [" . $_POST['product_name'] . "]";
        }
    } else {
        echo "The entered inventory amount is below the minimum threshold. Consider changing it.";
    }
} elseif(!($max_threshold == NULL)) {
    if($min_threshold >= $_POST["product_inventory"]) {
        $sql = "INSERT INTO products(Supplier_Code, Store_Code, Product_Code, Product_Name, Product_Category, Product_Inventory, Product_Price) VALUES('".mysqli_real_escape_string($connect, $_POST["supplier_code"])."', '".mysqli_real_escape_string($connect, $_POST["store_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_name"])."', '".mysqli_real_escape_string($connect, $_POST["product_category"])."', '".mysqli_real_escape_string($connect, $_POST["product_inventory"])."', '".mysqli_real_escape_string($connect, $_POST["product_price"])."')";
        if($connect->query($sql)) {
            echo "Product [" . $_POST['product_name'] . "] has been added";
        } else {
            echo "Failed to add Product [" . $_POST['product_name'] . "]";
        }
    } else {
        echo "The entered inventory amount is above the maximum threshold. Consider changing it.";
    }
} else {
    // Both Thresholds are NULL
    $sql = "INSERT INTO products(Supplier_Code, Store_Code, Product_Code, Product_Name, Product_Category, Product_Inventory, Product_Price) VALUES('".mysqli_real_escape_string($connect, $_POST["supplier_code"])."', '".mysqli_real_escape_string($connect, $_POST["store_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_name"])."', '".mysqli_real_escape_string($connect, $_POST["product_category"])."', '".mysqli_real_escape_string($connect, $_POST["product_inventory"])."', '".mysqli_real_escape_string($connect, $_POST["product_price"])."')";
    if($connect->query($sql)) {
        echo "Product [" . $_POST['product_name'] . "] has been added";
    } else {
        echo "Failed to add Product [" . $_POST['product_name'] . "]";
    }
}