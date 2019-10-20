<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

class Company {

    function getStores() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM company_stores";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo "<div class='col-xl-6 text-center'>
                                                <h4 class='text-blue text-underline'>" . $row["Store_Name"] . "</h4>
                                                <h4 class='text-blue'>" . $row["Store_Location"] . "</h4>
                                            </div>";
            }
        } else {
            echo "<h2 class='subtitle'>It seems that you've not inserted any stores yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/>";
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
                    echo "<tr><td><input type='text' name='name[]' placeholder='Store Name' value='" . $row["Store_Name"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='location[]' placeholder='Store Location' value='" . $row["Store_Location"] . "' class='modal-text form-control name_list' /></td>
                        <td><button type=\"button\" name=\"add\" id=\"add\" class=\"btn btn-success\">Add More</button></td></tr>";
                } else {
                    echo "<tr id='row" . $counter . "'><td><input type='text' name='name[]' placeholder='Store Name' value='" . $row["Store_Name"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='location[]' placeholder='Store Location' value='" . $row["Store_Location"] . "' class='modal-text form-control name_list' /></td>
                        <td><button type=\"button\" name=\"remove\" id='" . $counter . "' class=\"btn btn-danger btn_remove\">X</button></td></tr>";
                }
                $counter++;
            }
        } else {
            echo "<tr id='row'><td><input type=\"text\" name=\"name[]\" placeholder=\"Store Name\" class=\"modal-text form-control name_list\" /></td>
                                                                    <td><input type=\"text\" name=\"location[]\" placeholder=\"Store Location\" class=\"modal-text form-control name_list\" /></td>
                                                                    <td><button type=\"button\" name=\"add\" id=\"add\" class=\"btn btn-success\">Add More</button></td></tr>";
        }
        return $counter;
    }

}