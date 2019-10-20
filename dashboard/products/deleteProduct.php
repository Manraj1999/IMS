<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

session_start();

$DatabaseHandler = new DatabaseHandler();
$UserModal = new UserModal();

$connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

if(isset($_POST["Product_Code"])) {
    $sql = "DELETE FROM products WHERE Product_Code = '" . $_POST["Product_Code"] . "'";

    if($connect->query($sql)) {
        echo "Product [" . $_POST["Product_Code"] . "] has been deleted";
    } else {
        echo "There was an error while deleting Product [" . $_POST["Product_Code"] . "]";
    }
}