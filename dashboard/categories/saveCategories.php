<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

session_start();

$DatabaseHandler = new DatabaseHandler();
$UserModal = new UserModal();

$connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));
$number = count($_POST["name"]);

$delSQL = "TRUNCATE TABLE categories";
$connect->query($delSQL);

if($number > 0)
{
    for($i=0; $i<$number; $i++)
    {
        if(trim($_POST["name"][$i] != ''))
        {
            $sql = "INSERT INTO categories(Category_Name, Category_Abbr) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."', '".mysqli_real_escape_string($connect, $_POST["abbr"][$i])."')";
            $connect->query($sql);
        }
    }
    echo "Data Inserted";
}
else
{
    echo "Please enter the data correctly";
}