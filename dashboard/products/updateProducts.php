<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';

session_start();

$DatabaseHandler = new DatabaseHandler();
$UserModal = new UserModal();
$CompanyModal = new CompanyModal();

$connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

$min_threshold = $CompanyModal->getCompanyData("Minimum_Threshold");
$max_threshold = $CompanyModal->getCompanyData("Maximum_Threshold");

$name = $_POST["update_product_name"];
$inventory = $_POST["update_product_inventory"];
$code = $_POST["update_product_code"];
$category = $_POST["update_product_category"];
$supplier = $_POST["update_supplier_code"];
$store = $_POST["update_store_code"];
$price = $_POST["update_product_price"];

if(!($min_threshold == NULL) && !($max_threshold == NULL)) {
    if($max_threshold >= $inventory && $inventory >= $min_threshold) {
        $sql = "UPDATE products SET Product_Name='$name' , Product_Inventory=$inventory , Product_Category='$category' , Supplier_Code='$supplier' , Store_Code='$store' , Product_Price=$price WHERE Product_Code='$code'";
        if($result = $connect->query($sql)) {
            echo "Product [" . $_POST['update_product_code'] . "] has been updated";
        } else {
            echo "Failed to update Product [" . $_POST['update_product_code'] . "]";
        }
    } else {
        if($inventory > $max_threshold) {
            echo "The entered inventory amount is above the maximum threshold. Consider changing it.";
        } elseif($min_threshold > $inventory) {
            echo "The entered inventory amount is below the minimum threshold. Consider changing it.";
        }
    }
} elseif(!($min_threshold == NULL)) {
    if($inventory >= $max_threshold) {
        $sql = "UPDATE products SET Product_Name='$name' , Product_Inventory=$inventory , Product_Category='$category' , Supplier_Code='$supplier' , Store_Code='$store' , Product_Price=$price WHERE Product_Code='$code'";
        if($result = $connect->query($sql)) {
            echo "Product [" . $_POST['update_product_code'] . "] has been updated";
        } else {
            echo "Failed to update Product [" . $_POST['update_product_code'] . "]";
        }
    } else {
        echo "The entered inventory amount is below the minimum threshold. Consider changing it.";
    }
} elseif(!($max_threshold == NULL)) {
    if($min_threshold >= $inventory) {
        $sql = "UPDATE products SET Product_Name='$name' , Product_Inventory=$inventory , Product_Category='$category' , Supplier_Code='$supplier' , Store_Code='$store' , Product_Price=$price WHERE Product_Code='$code'";
        if($result = $connect->query($sql)) {
            echo "Product [" . $_POST['update_product_code'] . "] has been updated";
        } else {
            echo "Failed to update Product [" . $_POST['update_product_code'] . "]";
        }
    } else {
        echo "The entered inventory amount is above the maximum threshold. Consider changing it.";
    }
} else {
    // Both Thresholds are NULL
    $sql = "UPDATE products SET Product_Name='$name' , Product_Inventory=$inventory , Product_Category='$category' , Supplier_Code='$supplier' , Store_Code='$store' , Product_Price=$price WHERE Product_Code='$code'";
    if($result = $connect->query($sql)) {
        echo "Product [" . $_POST['update_product_code'] . "] has been updated";
    } else {
        echo "Failed to update Product [" . $_POST['update_product_code'] . "]";
    }
}