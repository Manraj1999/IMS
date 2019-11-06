<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

session_start();

$DatabaseHandler = new DatabaseHandler();
$UserModal = new UserModal();

$connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

$sql = "INSERT INTO products(Supplier_Code, Store_Code, Product_Code, Product_Name, Product_Category, Product_Inventory) VALUES('".mysqli_real_escape_string($connect, $_POST["supplier_code"])."', '".mysqli_real_escape_string($connect, $_POST["store_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_code"])."', '".mysqli_real_escape_string($connect, $_POST["product_name"])."', '".mysqli_real_escape_string($connect, $_POST["product_category"])."', '".mysqli_real_escape_string($connect, $_POST["product_inventory"])."')";
if($connect->query($sql)) {
    echo "Product [" . $_POST['product_code'] . "] has been added";
} else {
    echo "Failed to add Product [" . $_POST['product_code'] . "]";
}