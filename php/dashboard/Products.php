<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

class Products {

    function getProducts($limit) {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM products LIMIT " . $limit;
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {

                // Get Category
                $sqlGetCategory = "SELECT * FROM categories WHERE Category_Abbr='" . $row["Product_Category"] . "'";
                $categoryResults = $connection->query($sqlGetCategory);

                // Get Supplier
                $sqlGetSupplier = "SELECT * FROM suppliers WHERE Supplier_Code='" . $row["Supplier_Code"] . "'";
                $supplierResults = $connection->query($sqlGetSupplier);

                $categoryName = "";
                $supplierName = "";

                if($categoryResults->num_rows > 0) {
                    while($rowCat = $categoryResults->fetch_assoc()) {
                        $categoryName = $rowCat["Category_Name"];
                    }
                }

                if($supplierResults->num_rows > 0) {
                    while($rowSup = $supplierResults->fetch_assoc()) {
                        $supplierName = $rowSup["Supplier_Name"];
                    }
                }

                echo "<tr>
                                                        <th scope='row'>" . $row["Product_Code"] . "</th>
                                                        <td>" . $row["Product_Name"] . "</td>
                                                        <td>" . $categoryName . " <span class='badge badge-danger'>" . $row["Product_Category"] . "</span></td>
                                                        <td>" . $row["Product_Inventory"] . "</td>
                                                        <td>" . $supplierName . " <span class='badge badge-light'>" . $row["Supplier_Code"] . "</span></td>
                                                        <td>
                                                            <div class='dropdown'>
                                                                <button class='btn btn-primary dropdown-toggle m--3' type='button' id='action-" . $row["Product_Code"] ."' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                    Action
                                                                </button>
                                                                <div class='dropdown-menu' aria-labelledby='actionButton'>
                                                                    <a class='dropdown-item edit-data' id='" . $row["Product_Code"] ."' data-toggle='modal' data-target='#updateProducts' href='#'>Edit</a>
                                                                    <a class='dropdown-item delete-data' id='" . $row["Product_Code"] ."' href='#'>Delete</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>";
            }
        } else {
            echo "<tr><tr/><h2 class='subtitle text-red text-center'>It seems that you've not inserted any products yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/>";
        }
    }

    function getCategoriesForAddingProducts() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM categories";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                echo "<option value='" . $row['Category_Abbr'] . "'>" . $row['Category_Name'] . "</option>";
            }
        }
    }

    function getSuppliersForAddingProducts() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM suppliers";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                echo "<option value='" . $row['Supplier_Code'] . "'>" . $row['Supplier_Name'] . "</option>";
            }
        }
    }


}