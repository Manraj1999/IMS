<?php

include $_SERVER['DOCUMENT_ROOT'] . '/ims/settings/Database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/ims/settings/Messages.php';

class DatabaseHandler {

    function getMySQLiConnection() {
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if($connection->connect_error) {
            die(MSG_ERROR_CONNECT_DB);
        } else {
            return $connection;
        }
    }

    function getAdminMySQLiConnection() {
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS);

        if($connection->connect_error) {
            die(MSG_ERROR_CONNECT_DB);
        } else {
            return $connection;
        }
    }

    function getCompanyMySQLiConnection($company_id) {
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, $company_id);

        if($connection->connect_error) {
            die(MSG_ERROR_CONNECT_DB);
        } else {
            return $connection;
        }
    }

}