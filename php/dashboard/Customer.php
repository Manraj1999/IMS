<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';

class Customer {

    function getCompanyList() {
        $DatabaseHandler = new DatabaseHandler();

        $sql = "SELECT * FROM ims.company_list WHERE Status='APPROVED'";
        $connection = $DatabaseHandler->getAdminMySQLiConnection();

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo "<option value='" . $row["Company_ID"] . "'>" . $row["Company_Name"] . "</option>";
            }
        } else {
            echo "";
        }
    }

    function getProductsFromCompany($company_id) {
        echo "<option value='default' selected disabled hidden>Product Name</option>";

        $DatabaseHandler = new DatabaseHandler();
        $CompanyModal = new CompanyModal();

        $sql = "SELECT * FROM products";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($company_id);

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo "<option value='" . $row["Product_ID"] . "'>" . $row["Product_Name"] . " - " . $CompanyModal->getCompanyDataWithoutSession("Currency_Format", $company_id) . $row["Product_Price"] . "/pc</option>";
            }
        } else {
            echo "";
        }
    }

    function getNoProducts() {
        echo "<option value='default' selected disabled hidden>Company not selected</option>";
    }

    function getMaxInventoryForProduct($company_id ,$product_id) {
        $DatabaseHandler = new DatabaseHandler();

        $sql = "SELECT * FROM products WHERE Product_ID='$product_id'";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($company_id);

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo $row["Product_Inventory"];
            }
        } else {
            echo "";
        }
    }

    function getPrice($company_id ,$product_id, $product_quantity) {
        $DatabaseHandler = new DatabaseHandler();

        $sql = "SELECT * FROM products WHERE Product_ID='$product_id'";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($company_id);

        $results = $connection->query($sql);

        $price = 0;
        $total = 0;

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                $price = $row["Product_Price"];
            }

            $total = $price * $product_quantity;

            echo $total;
        } else {
            echo $total;
        }
    }

    function getProductNameByID($product_id, $company_id) {
        $DatabaseHandler = new DatabaseHandler();

        $sql = "SELECT * FROM products WHERE Product_ID='$product_id'";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($company_id);

        $results = $connection->query($sql);

        $name = "";

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                $name = $row["Product_Name"];
            }
            return $name;
        } else {
            return "";
        }
    }

    function order($company_id, $product_id, $product_quantity, $product_price, $customer_name) {
        $DatabaseHandler = new DatabaseHandler();

        $error = false;

        $date = date( 'Y-m-d H:i:s');

        $sql = "INSERT INTO orders (Product_ID, Customer_Name, Product_Quantity, Total_Amount, Order_Date) VALUES ('$product_id', '$customer_name', '$product_quantity', $product_price, '$date')";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($company_id);

        $results = $connection->query($sql);

        if($results) {
            // Get current inventory from 'products' table
            $currentInv = 0;

            $getCurrentInvSQL = "SELECT * FROM products WHERE Product_ID='$product_id'";
            $resultGetCurrentInv = $connection->query($getCurrentInvSQL);

            if($resultGetCurrentInv->num_rows > 0) {
                while($row = $resultGetCurrentInv->fetch_assoc()) {
                    $currentInv = $row["Product_Inventory"];
                }
            }

            $newInv = $currentInv - $product_quantity;

            $updateInventorySQL = "UPDATE products SET Product_Inventory = '$newInv' WHERE Product_ID = '$product_id'";
            $resultUpdate = $connection->query($updateInventorySQL);

            if($resultUpdate) {
                $error = false;
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }

        if(!$error) {
            echo "Your order of " . $product_quantity . "x " . $this->getProductNameByID($product_id, $company_id) . " has been placed";
        } else {
            echo "There was an issue while placing you order.";
        }
    }

}