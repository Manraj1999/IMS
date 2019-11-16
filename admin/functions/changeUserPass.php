<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/Tools.php';

    session_start();

    $DatabaseHandler = new DatabaseHandler();
    $Tools = new Tools();

    $response["error"] = false;

    $connect = $DatabaseHandler->getCompanyMySQLiConnection($_POST["Company_ID"]);
    $connectAdmin = $DatabaseHandler->getAdminMySQLiConnection();

    $User_ID = $_POST["User_ID"];

    if($_POST["user_pswd_confirm"] !== $_POST["user_pswd"]) {
        echo "The passwords do not match. Please try again!";
    } else {
        $User_Salt = $Tools->hashPasswordFromInput($_POST["user_pswd"]);

        $userEmail = $_POST["Email"];
        $userName = "";

        $sql = "UPDATE users SET User_Salt='$User_Salt' WHERE User_Email='$userEmail'";
        if($result = $connect->query($sql)) {

            $sqlChangeInMainDB = "UPDATE ims.users SET User_Salt='$User_Salt' WHERE User_Email='$userEmail'";
            $sqlChangeInMainCompanyDB = "UPDATE ims.company_list SET Password_Salt='$User_Salt' WHERE Email_Address='$userEmail'";
            if($connectAdmin->query($sqlChangeInMainDB) && $connectAdmin->query($sqlChangeInMainCompanyDB)) {
                $response["error"] = false;
            } else {
                $response["error"] = true;
            }
        } else {
            $response["error"] = true;
        }

        if($response["error"] == false) {
            echo "The supervisor for " . $_POST["Company_Name"] . "'s password has been updated";
        } else {
            echo "Failed to update the supervisor of " . $_POST["Company_Name"] . "'s password";
        }
    }