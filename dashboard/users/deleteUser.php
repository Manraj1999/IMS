<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/Tools.php';

    session_start();

    $DatabaseHandler = new DatabaseHandler();
    $UserModal = new UserModal();
    $Tools = new Tools();

    $response["error"] = false;

    $connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));
    $connectAdmin = $DatabaseHandler->getAdminMySQLiConnection();

    if(isset($_POST["User_ID"])) {
        $User_ID = $_POST["User_ID"];

        $userEmail = "";
        $userName = "";

        $getNewDataSQL = "SELECT * FROM users WHERE User_ID='$User_ID'";

        $sql = "DELETE FROM users WHERE User_ID='$User_ID'";



        if($results = $connect->query($getNewDataSQL)) {
            if($results->num_rows > 0) {
                while($row = $results->fetch_assoc()) {
                    $userEmail = $row["User_Email"];
                    $userName = $row["User_FullName"];
                }
            }
        }

        $sqlDeleteInMainDB = "DELETE FROM ims.users WHERE User_Email='$userEmail'";
        if($connectAdmin->query($sqlDeleteInMainDB)) {
            $response["error"] = false;
        } else {
            $response["error"] = true;
        }

        if($result = $connect->query($sql)) {
            $response["error"] = false;
        } else {
            $response["error"] = true;
        }

        if($response["error"] == false) {
            echo "User [" . $userName . "] has been deleted";
        } else {
            echo "Failed to delete User [" . $userName . "]";
        }
    }