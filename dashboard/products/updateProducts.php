<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

session_start();

$DatabaseHandler = new DatabaseHandler();
$UserModal = new UserModal();

$connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

$name = $_POST["update_product_name"];
$inventory = $_POST["update_product_inventory"];
$code = $_POST["update_product_code"];

$sql = "UPDATE products SET Product_Name='$name' , Product_Inventory=$inventory WHERE Product_Code='$code'";
if($result = $connect->query($sql)) {
    echo "Product [" . $_POST['update_product_code'] . "] has been updated";
} else {
    echo "Failed to update Product [" . $_POST['update_product_code'] . "]";
}