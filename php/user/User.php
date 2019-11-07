<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/ims/php/DatabaseHandler.php';
include_once 'Tools.php';

class User {

    function login($emailFromUser, $passwordFromUser) {
        // Variable Defines
        $password_hash = null;
        $response = array();

        // Connect to Database
        $DatabaseHandler = new DatabaseHandler();
        $connection = $DatabaseHandler->getMySQLiConnection();

        // Get password_hash from Database
        $getHashSQL = 'SELECT ' . TABLE_USER_PASS_HASH . ' FROM ' . TABLE_NAME . ' WHERE ' . TABLE_USER_EMAIL . '="' . $emailFromUser . '"';
        $result = $connection->query($getHashSQL);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $password_hash = $row[TABLE_USER_PASS_HASH];
            }

            // Verify password entered by user with the password hash
            if(password_verify($passwordFromUser, $password_hash)) {
                // Login: Success
                $response['error'] = false;
                $response['status_code'] = 0;

            } else {
                // Login: Incorrect Password
                $response['error'] = true;
                $response['status_code'] = 2;
            }
        } else {
            // Login: Failed
            $response['error'] = true;
            $response['status_code'] = 1;
        }
        return $response;
    }

    function register($data, $companyName, $invType) {
        // Variable Defines
        $emailFromUser = "";
        $companyID = $data[0][1];
        $response = array();

        // Obtain Database Table Data and Values for Each Table
        $databaseTables = "";
        $tableValues = "";

        $numberOfTables = sizeof($data);

        $apiTools = new Tools();

        for($row = 0; $row < $numberOfTables; $row++) {

            $data[$row][1] = $apiTools->hashPasswordFromArray($data, $row);

            // Update Strings for SQL Statement
            $databaseTables .= $data[$row][0];
            $tableValues .= "'" . $data[$row][1] . "'";

            // Make sure last table and value doesn't have a ','
            if(!($row === $numberOfTables - 1)) {
                $databaseTables .= ',';
                $tableValues .= ',';
            }

            // Get email by looking for '@' to check if User is already registered
            if(strpos($data[$row][1], '@') !== false) {
                $emailFromUser = $data[$row][1];
            }
        }

        // Check if User is already registered
        if($this->emailExist($emailFromUser)) {
            $response['error'] = true;
            $response['status_code'] = 2;
        } else {
            // Connect to Database
            $DatabaseHandler = new DatabaseHandler();
            $connection = $DatabaseHandler->getMySQLiConnection();

            // Register User
            $registerSQL = "INSERT INTO " . TABLE_NAME . " (" . $databaseTables . ") VALUES (" . $tableValues . ")";
            $result = $connection->query($registerSQL);

            if($result) {
                $response['error'] = false;
                $response['status_code'] = 0;
            } else {
                $response['error'] = true;
                $response['status_code'] = 1;
            }

            // Create DB and Tables
            $companyDBTablesResponse = $apiTools->createCompanyDBAndTables($companyID, $response, $invType);

            // Add Company Info
            if($companyDBTablesResponse['error'] !== true) {
                $su_id = "";
                // Get Supervisor ID
                $supervisorConnection = $DatabaseHandler->getMySQLiConnection();
                $getSupervisorIDSQL = "SELECT * FROM users WHERE User_Email = '" . $emailFromUser . "'";
                $resultSupervisor = $supervisorConnection->query($getSupervisorIDSQL);

                $userFullName = "";
                $userSalt = "";

                if($resultSupervisor->num_rows > 0) {
                    while($row = $resultSupervisor->fetch_assoc()) {
                        $su_id = $row['User_ID'];
                        $userFullName = $row['User_FullName'];
                        $userSalt = $row['User_Salt'];
                    }
                }

                $companyConnection = $DatabaseHandler->getCompanyMySQLiConnection($companyID);
                $updateCompanyInfoSQL = "INSERT INTO company_info (Company_Name, SU_ID, Inventory_Type) VALUES ('" . $companyName . "', '" . $su_id . "', '" . $invType . "')";

                $companyResult = $companyConnection->query($updateCompanyInfoSQL);

                if($companyResult) {
                    $response['error'] = false;
                    $response['status_code'] = 0;

                    // Add User to Company Users
                    $addUserSQL = "INSERT INTO users(User_FullName, User_Email, User_Salt, User_Type) VALUES ('" . $userFullName . "', '" . $emailFromUser . "', '" . $userSalt . "', 'SUPERVISOR')";
                    $addUserResult = $companyConnection->query($addUserSQL);

                    if($addUserResult) {
                        $response['error'] = false;
                        $response['status_code'] = 0;
                    } else {
                        $response['error'] = true;
                        $response['status_code'] = 1;
                        echo $companyConnection->error;
                    }

                } else {
                    $response['error'] = true;
                    $response['status_code'] = 1;
                    echo $companyConnection->error;
                }

            }

        }

        return $response;
    }

    private function emailExist($emailFromUser) {
        // Connect to Database
        $DatabaseHandler = new DatabaseHandler();
        $connection = $DatabaseHandler->getMySQLiConnection();

        // Check if email exists in Database
        $checkEmailSQL = 'SELECT ' . TABLE_USER_EMAIL . ' FROM ' . TABLE_NAME . ' WHERE ' . TABLE_USER_EMAIL . '="' . $emailFromUser . '"';
        $checkEmailResult = $connection->query($checkEmailSQL);

        if($checkEmailResult->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * For development purpose:
     * Display error messages when
     * an error is presented.
     */
    function displayMessage($response, $type) {
        $message = null;
        if(strcasecmp($type, "login") == 0) {
            if($response['status_code'] == 0) {
                $message = MSG_LOGIN_SUCCESS;
            } elseif($response['status_code'] == 1) {
                $message = MSG_LOGIN_NO_RESULT;
            } elseif($response['status_code'] == 2) {
                $message = MSG_LOGIN_PASSWORD_VERIFY_FAIL;
            }
        } elseif(strcasecmp($type, "register") == 0) {
            if($response['status_code'] == 0) {
                $message = MSG_REGISTER_SUCCESS;
            } elseif($response['status_code'] == 1) {
                $message = MSG_REGISTER_FAIL;
            } elseif($response['status_code'] == 2) {
                $message = MSG_REGISTER_EMAIL_EXIST;
            } elseif($response['status_code'] == 3) {
                $message = MSG_DB_CREATION_FAILED;
            } elseif($response['status_code'] == 4) {
                $message = MSG_TABLE_CREATION_FAILED;
            } elseif($response['status_code'] ==5 ) {
                $message = MSG_TABLE_CREATION_INCORRECT_INV_TYPE;
            }
        } else {
            $message = "API Configuration: The type entered was incorrect!";
        }

        return $message;
    }

    function logout() {
        $_SESSION = array();

        if(ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header("Location: /ims/index.php");
    }

}