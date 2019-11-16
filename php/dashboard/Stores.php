<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

class Stores {

    function getStores() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM company_stores";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo "
                    <div class=\"col-xl-6 col-lg-6 mb-4\">
                    <a class='product-store' data-toggle=\"modal\" data-target=\"#showTable\" href=\"#\" id='" . $row["Store_Code"] . "'>
                        <div class=\"card card-stats bg-gradient-dark\">
                            <div class=\"card-body\">
                                <h3 class=\"text-center text-primary\">" . $row["Store_Name"] . "</h3>
                                <h4 class=\"text-center text-primary\">" . $row["Store_Location"] . "</h4>
                                <br/>
                                <h1 class=\"text-center\"><span class='badge badge-light text-white p-3 bg-primary'>" . $this->getNumberOfProductsStores($row["Store_Code"]) . "</span></h1>
                            </div>
                        </div>
                    </a>
                </div>
                ";
            }
        } else {
            echo "<div class='col-sm-2'></div><div class='col-sm-8 card card-stats card-body mt--3'><h2 class='subtitle text-purple'>It seems that you've not inserted any stores yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/></div><div class='col-sm-2'></div>";
        }
    }

    function checkStoresLogic() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM company_stores";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);
        $counter = 1;
        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                if($counter == 1) {
                    echo "<tr><td><input type='text' name='code[]' placeholder='Store Code' value='" . $row["Store_Code"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='name[]' placeholder='Store Name' value='" . $row["Store_Name"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='location[]' placeholder='Store Location' value='" . $row["Store_Location"] . "' class='modal-text form-control name_list' /></td>
                        <td><button type=\"button\" name=\"add\" id=\"add\" class=\"btn btn-success\">Add More</button></td></tr>";
                } else {
                    echo "<tr id='row" . $counter . "'><td><input type='text' name='code[]' placeholder='Store Code' value='" . $row["Store_Code"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='name[]' placeholder='Store Name' value='" . $row["Store_Name"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='location[]' placeholder='Store Location' value='" . $row["Store_Location"] . "' class='modal-text form-control name_list' /></td>
                        <td><button type=\"button\" name=\"remove\" id='" . $counter . "' class=\"btn btn-danger btn_remove\">X</button></td></tr>";
                }
                $counter++;
            }
        } else {
            echo "<tr id='row'><td><input type=\"text\" name=\"code[]\" placeholder=\"Store Code\" class=\"modal-text form-control name_list\" /></td>
                                                                    <td><input type=\"text\" name=\"name[]\" placeholder=\"Store Name\" class=\"modal-text form-control name_list\" /></td>
                                                                    <td><input type=\"text\" name=\"location[]\" placeholder=\"Store Location\" class=\"modal-text form-control name_list\" /></td>
                                                                    <td><button type=\"button\" name=\"add\" id=\"add\" class=\"btn btn-success\">Add More</button></td></tr>";
        }
        return $counter;
    }

    function getProductsForSpecificStore($Store_Code) {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM products WHERE Store_Code = '" . $Store_Code . "'";
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

                // Get Store
                $sqlGetStore = "SELECT * FROM company_stores WHERE Store_Code = '" . $row["Store_Code"] . "'";
                $storeResults = $connection->query($sqlGetStore);

                $categoryName = "";
                $supplierName = "";
                $storeName = "";

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

                if($storeResults->num_rows > 0) {
                    while($rowStore = $storeResults->fetch_assoc()) {
                        $storeName = $rowStore["Store_Name"];
                    }
                }

                echo "<tr>
                                                        <th scope='row'>" . $row["Product_Code"] . "</th>
                                                        <td>" . $row["Product_Name"] . "</td>
                                                        <td>" . $categoryName . " <span class='badge badge-danger'>" . $row["Product_Category"] . "</span></td>
                                                        <td>" . $row["Product_Inventory"] . "</td>
                                                        <td>" . $storeName . "</td>
                                                        <td>" . $supplierName . " <span class='badge badge-light'>" . $row["Supplier_Code"] . "</span></td>
                                                    </tr>";
            }
        } else {
            echo "<tr><tr/><h2 class='subtitle text-red text-center'>It seems that you've not inserted any products yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/>";
        }
    }

    function getNumberOfProductsStores($Store_Code) {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM products WHERE Store_Code =  '" . $Store_Code . "'";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);
        $count = 0;
        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                $count++;
            }
        } else {
            $count = 0;
        }

        return $count;
    }

}