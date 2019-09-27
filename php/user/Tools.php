<?php


class Tools {

    /*
     * The hashPasswordFromArray() function
     * searches for the password entry that
     * has been inserted in the array using
     * keywords such as:
     * 'pass', 'password', 'pswd', 'hash'.
     *
     * Fallback to pre-written settings data.
     */
    function hashPasswordFromArray($data, $row) {
        // Initialize variable with base values
        $pswd_hash = $data[$row][1];

        // Get Password by looking for keywords in table names
        $search = array("pass", "password", 'pswd', 'hash', TABLE_USER_PASS_HASH);

        if(preg_match("/{$search[0]}/i", $data[$row][0]) ||
            preg_match("/{$search[1]}/i", $data[$row][0]) ||
            preg_match("/{$search[2]}/i", $data[$row][0]) ||
            preg_match("/{$search[3]}/i", $data[$row][0]) ||
            preg_match("/{$search[4]}/i", $data[$row][0])) {

            // Encrypt User Password
            $pswd_hash = password_hash($data[$row][1], PASSWORD_DEFAULT);
        }

        return $pswd_hash;
    }

    function createCompanyDBAndTables($companyID, $response) {
        $DatabaseHandler = new DatabaseHandler();

        // Create Custom Database for Company
        $connectionCompanyCreate = $DatabaseHandler->getAdminMySQLiConnection();
        $companyCreateSQL = "CREATE DATABASE " . $companyID;

        $resultCompanyCreate = $connectionCompanyCreate->query($companyCreateSQL);

        if($resultCompanyCreate) {
            $response['error'] = false;
            $response['status_code'] = 0;
        } else {
            $response['error'] = true;
            $response['status_code'] = 3;
        }

        // Create Tables for the Custom Company Database
        $connectionCompanyTablesCreations = $DatabaseHandler->getCompanyMySQLiConnection($companyID);
        $companyInfoSQL = "CREATE TABLE company_info (
                Company_ID VARCHAR(32) PRIMARY KEY,
                SU_ID VARCHAR(32) NOT NULL,
                Company_Name VARCHAR(128) NOT NULL,
                Company_Location VARCHAR(128)
            )";
        $companyStoresSQL = "CREATE TABLE company_stores (
                Store_ID VARCHAR(32) PRIMARY KEY,
                Store_Name VARCHAR(32) NOT NULL,
                Store_Location VARCHAR(128)
            )";
        $supplierSQL = "CREATE TABLE suppliers (
                Supplier_ID VARCHAR(32) PRIMARY KEY,
                Supplier_Name VARCHAR(128) NOT NULL
            )";
        $productsSQL = "CREATE TABLE products (
                Product_ID VARCHAR(32) PRIMARY KEY,
                Product_Name VARCHAR(128) NOT NULL,
                Product_Inventory INT(32) NOT NULL
            )";
        $purchasesSQL = "CREATE TABLE purchases (
                Purchase_ID VARCHAR(32) PRIMARY KEY,
                Product_ID VARCHAR(32) NOT NULL,
                Supplier_ID VARCHAR(32) NOT NULL,
                Amount_Received INT(32) NOT NULL,
                Purchase_Date DATETIME NOT NULL
            )";
        $ordersSQL = "CREATE TABLE orders (
                Order_ID VARCHAR(32) PRIMARY KEY,
                Product_ID VARCHAR(32) NOT NULL,
                Order_Person_Name VARCHAR(128) NOT NULL,
                Product_Amount VARCHAR(32) NOT NULL,
                Order_Date DATETIME NOT NULL
            )";

        $tablesSQL = [$companyInfoSQL, $companyStoresSQL, $supplierSQL, $productsSQL, $purchasesSQL, $ordersSQL];

        foreach($tablesSQL as $k => $sql) {
            $tablesResult = $connectionCompanyTablesCreations->query($sql);

            if($tablesResult) {
                $response['error'] = false;
                $response['status_code'] = 0;
            } else {
                $response['error'] = true;
                $response['status_code'] = 4;
            }
        }
    }

}