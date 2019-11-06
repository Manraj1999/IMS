<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

class Supplier {

    function getSuppliers() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM suppliers";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo "<button type='button' name='" . $row["Supplier_Code"] . "' id='sup-btns' class='btn btn-danger mb-2'>
                                                " . $row["Supplier_Name"] . " <span class='badge badge-light text-danger'>" . $row["Supplier_Code"] . "</span>
                                                <span class='badge badge-light text-danger m--2'>" . $this->getNumberOfProductsSupplier($row["Supplier_Code"]) . "</span>
                                            </button>";
            }
        } else {
            echo "<h2 class='subtitle text-red'>It seems that you've not inserted any suppliers yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/>";
        }
    }

    function checkSuppliersLogic() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM suppliers";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);
        $counter = 1;
        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                if($counter == 1) {
                    echo "<tr><td><input type='text' name='name[]' placeholder='Supplier Name' value='" . $row["Supplier_Name"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='code[]' placeholder='Supplier Code' value='" . $row["Supplier_Code"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='loc[]' placeholder='Supplier Location' value='" . $row["Supplier_Location"] . "' class='modal-text form-control name_list' /></td>
                        <td><button type=\"button\" name=\"add\" id=\"add\" class=\"btn btn-success\">Add More</button></td></tr>";
                } else {
                    echo "<tr id='row" . $counter . "'><td><input type='text' name='name[]' placeholder='Supplier Name' value='" . $row["Supplier_Name"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='code[]' placeholder='Supplier Code' value='" . $row["Supplier_Code"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='loc[]' placeholder='Supplier Code' value='" . $row["Supplier_Location"] . "' class='modal-text form-control name_list' /></td>
                        <td><button type=\"button\" name=\"remove\" id='" . $counter . "' class=\"btn btn-danger btn_remove\">X</button></td></tr>";
                }
                $counter++;
            }
        } else {
            echo "<tr id='row'>
                    <td><input type='text' name='name[]' placeholder='Supplier Name' class='modal-text form-control name_list' /></td>
                    <td><input type='text' name='code[]' placeholder='Supplier Code' class='modal-text form-control name_list' /></td>
                    <td><input type='text' name='loc[]' placeholder='Supplier Location' class='modal-text form-control name_list' /></td>
                    <td><button type='button' name='add' id='add' class='btn btn-success'>Add More</button></td></tr>";
        }
        return $counter;
    }

    function getNumberOfProductsSupplier($Supplier_Code) {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM products WHERE Supplier_Code =  '" . $Supplier_Code . "'";
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