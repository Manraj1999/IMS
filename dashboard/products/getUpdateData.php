<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

session_start();

$DatabaseHandler = new DatabaseHandler();
$UserModal = new UserModal();

$connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

if(isset($_POST["Product_Code"])) {
    $sql = "SELECT * FROM products WHERE Product_Code = '" . $_POST["Product_Code"] . "'";
    $result = $connect->query($sql);

    $row = $result->fetch_array();
    echo json_encode($row);
}