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

    function sendErrorMessage($message) {
        echo "<div class='message'>
        <div class='alert alert-danger alert-dismissible inner-message fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>" . $message . "</div></div>";
    }

    function createCompanyDBAndTables($companyID, $response, $invType) {
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

        if($response['error'] !== true) {
            if($invType == "STOCK") {
                // Create Tables for the Custom Company Database
                $connectionCompanyTablesCreations = $DatabaseHandler->getCompanyMySQLiConnection($companyID);
                $companyInfoSQL = "CREATE TABLE company_info (
                Company_ID INT NOT NULL AUTO_INCREMENT,
                SU_ID VARCHAR(32),
                Company_Name VARCHAR(128),
                Company_Location VARCHAR(128),
                Inventory_Type VARCHAR(32),
                PRIMARY KEY (Company_ID)
            )";
                $companyStoresSQL = "CREATE TABLE company_stores (
                Store_ID INT NOT NULL AUTO_INCREMENT,
                Store_Code VARCHAR(32) NOT NULL,
                Store_Name VARCHAR(128) NOT NULL,
                Store_Location VARCHAR(128),
                PRIMARY KEY (Store_ID)
            )";
                $categoriesSQL = "CREATE TABLE categories (
                Category_ID INT NOT NULL AUTO_INCREMENT,
                Category_Abbr VARCHAR(32) NOT NULL,
                Category_Name VARCHAR(128) NOT NULL,
                PRIMARY KEY (Category_ID)
            )";
                $supplierSQL = "CREATE TABLE suppliers (
                Supplier_ID INT NOT NULL AUTO_INCREMENT,
                Supplier_Code VARCHAR(32) NOT NULL,
                Supplier_Name VARCHAR(128) NOT NULL,
                Supplier_Location VARCHAR(128) NOT NULL,
                PRIMARY KEY (Supplier_ID)
            )";
                $productsSQL = "CREATE TABLE products (
                Product_ID INT NOT NULL AUTO_INCREMENT,
                Supplier_Code VARCHAR(32) NOT NULL,
                Store_Code VARCHAR(32) NOT NULL,
                Product_Code VARCHAR(128) NOT NULL,
                Product_Name VARCHAR(128) NOT NULL,
                Product_Category VARCHAR(32) NOT NULL,
                Product_Inventory INT(32) NOT NULL,
                PRIMARY KEY (Product_ID)
            )";
                $purchasesSQL = "CREATE TABLE purchases (
                Purchase_ID INT NOT NULL AUTO_INCREMENT,
                Product_ID VARCHAR(32) NOT NULL,
                Supplier_ID VARCHAR(32) NOT NULL,
                Amount_Received INT(32) NOT NULL,
                Purchase_Date DATETIME NOT NULL,
                PRIMARY KEY (Purchase_ID)
            )";
                $ordersSQL = "CREATE TABLE orders (
                Order_ID INT NOT NULL AUTO_INCREMENT,
                Product_ID VARCHAR(32) NOT NULL,
                Order_Person_Name VARCHAR(128) NOT NULL,
                Product_Amount VARCHAR(32) NOT NULL,
                Order_Date DATETIME NOT NULL,
                PRIMARY KEY (Order_ID)
            )";
                $usersSQL = "CREATE TABLE users (
                User_ID INT NOT NULL,
                User_FullName VARCHAR(128) NOT NULL,
                User_Email VARCHAR(128) NOT NULL,
                User_Type VARCHAR(32) NOT NULL,
                PRIMARY KEY (User_ID)
            )";

                $tablesSQL = [$companyInfoSQL, $companyStoresSQL, $categoriesSQL, $supplierSQL, $productsSQL, $purchasesSQL, $ordersSQL, $usersSQL];

                foreach($tablesSQL as $k => $sql) {
                    $tablesResult = $connectionCompanyTablesCreations->query($sql);

                    if ($tablesResult) {
                        $addInitialDataSQL = "INSERT INTO categories(Category_Abbr, Category_Name) VALUES ('UN-CAT', 'Uncategorized')";
                        $initialSetup = $connectionCompanyTablesCreations->query($addInitialDataSQL);

                        if($initialSetup) {
                            $response['error'] = false;
                            $response['status_code'] = 0;
                        } else {
                            $response['error'] = true;
                            $response['status_code'] = 4;
                        }
                    } else {
                        $response['error'] = true;
                        $response['status_code'] = 4;
                    }
                }
            } else {
                $response['error'] = true;
                $response['status_code'] = 5;
            }
        }
        return $response;
    }

}