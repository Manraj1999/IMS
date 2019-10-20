<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

class Categories {

    function getCategories() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM categories";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                echo "<button type='button' name='" . $row["Category_Abbr"] . "' id='cat-btns' class='btn btn-danger mb-2'>
                                                " . $row["Category_Name"] . " <span class='badge badge-light text-danger'>" . $row["Category_Abbr"] . "</span>
                                            </button>";
            }
        } else {
            echo "<h2 class='subtitle text-red'>It seems that you've not inserted any categories yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/>";
        }
    }

    function checkCategoriesLogic() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM categories";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);
        $counter = 1;
        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                if($counter == 1) {
                    echo "<tr><td><input type='text' name='name[]' placeholder='Category Name' value='" . $row["Category_Name"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='abbr[]' placeholder='Category Abbreviation' value='" . $row["Category_Abbr"] . "' class='modal-text form-control name_list' /></td>
                        <td><button type=\"button\" name=\"add\" id=\"add\" class=\"btn btn-success\">Add More</button></td></tr>";
                } else {
                    echo "<tr id='row" . $counter . "'><td><input type='text' name='name[]' placeholder='Category Name' value='" . $row["Category_Name"] . "' class='modal-text form-control name_list' /></td>
                        <td><input type='text' name='abbr[]' placeholder='Category Abbreviation' value='" . $row["Category_Abbr"] . "' class='modal-text form-control name_list' /></td>
                        <td><button type=\"button\" name=\"remove\" id='" . $counter . "' class=\"btn btn-danger btn_remove\">X</button></td></tr>";
                }
                $counter++;
            }
        } else {
            echo "<tr id='row'>
                    <td><input type='text' name='name[]' placeholder='Category Name' class='modal-text form-control name_list' /></td>
                    <td><input type='text' name='abbr[]' placeholder='Category Abbreviation' class='modal-text form-control name_list' /></td>
                    <td><button type='button' name='add' id='add' class='btn btn-success'>Add More</button></td></tr>";
        }
        return $counter;
    }

}