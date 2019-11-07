<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/Tools.php';

    session_start();

    $DatabaseHandler = new DatabaseHandler();
    $UserModal = new UserModal();
    $Tools = new Tools();
    $response['error'] = false;

    if($_POST["user_password"] !== $_POST["user_password_confirm"]) {
        echo "The passwords do not match!";
    } else {
        $connect = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));
        $connectAdmin = $DatabaseHandler->getAdminMySQLiConnection();

        $userSalt = $Tools->hashPasswordFromInput($_POST["user_password"]);

        $sql = "INSERT INTO users(User_FullName, User_Email, User_Salt, User_Type) VALUES ('".mysqli_real_escape_string($connect, $_POST["user_fullname"])."', '".mysqli_real_escape_string($connect, $_POST["user_email"])."', '" . $userSalt ."', 'USER')";
        if($connect->query($sql)) {
            $response['error'] = false;
        } else {
            $response['error'] = true;
        }

        if($response['error'] == false) {
            $Company_ID = $UserModal->getUserData("Company_ID");
            $addUserToMainDBSQL = "INSERT INTO ims.users(Company_ID, User_FullName, User_Email, User_Salt, User_Type) VALUES ('" . $Company_ID . "','".mysqli_real_escape_string($connect, $_POST["user_fullname"])."', '".mysqli_real_escape_string($connect, $_POST["user_email"])."', '" . $userSalt ."', 'USER')";

            if($connectAdmin->query($addUserToMainDBSQL)) {
                $response['error'] = false;
            } else {
                $response['error'] = true;
            }
        }

        if($response['error'] == false) {
            echo "User [" . $_POST['user_fullname'] . "] has been added";
        } else {
            echo "Failed to add User [" . $_POST['user_fullname'] . "]";
        }
    }