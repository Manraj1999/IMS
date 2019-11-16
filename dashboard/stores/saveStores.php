<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

session_start();

$DatabaseHandler = new DatabaseHandler();
$UserModal = new UserModal();

$connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));
$number = count($_POST["name"]);

$delSQL = "TRUNCATE TABLE company_stores";
$connect->query($delSQL);

if($number > 0)
{
    for($i=0; $i<$number; $i++)
    {
        if(trim($_POST["name"][$i] != ''))
        {
            $sql = "INSERT INTO company_stores(Store_Code, Store_Name, Store_Location) VALUES('".mysqli_real_escape_string($connect, $_POST["code"][$i])."', '".mysqli_real_escape_string($connect, $_POST["name"][$i])."', '".mysqli_real_escape_string($connect, $_POST["location"][$i])."')";
            $connect->query($sql);
        }
    }
    echo "The stores have been updated.";
}
else
{
    echo "There was an issue while updating the stores.";
}