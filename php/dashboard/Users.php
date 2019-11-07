<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

class Users {

    function getUsers() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM users";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {

                echo "<tr>
                                                        <th scope='row'>" . $row["User_ID"] . "</th>
                                                        <td>" . $row["User_FullName"] . "</td>
                                                        <td>" . $row["User_Email"] . "
                                                        <td>" . $row["User_Type"] . "</td>
                                                        <td>
                                                            <div class='dropdown'>
                                                                <button class='btn btn-primary dropdown-toggle m--3' type='button' id='action-" . $row["User_ID"] ."' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                    Action
                                                                </button>
                                                                <div class='dropdown-menu' aria-labelledby='actionButton'>
                                                                    <a class='dropdown-item edit-data' id='" . $row["User_ID"] ."' data-toggle='modal' data-target='#updateProducts' href='#'>Edit</a>
                                                                    <a class='dropdown-item delete-data' id='" . $row["User_ID"] ."' href='#'>Delete</a>
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

    function getUsersWithSearch($search_data) {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $sql = "SELECT * FROM users
                WHERE User_ID LIKE '%" . $search_data . "%'
                OR User_FullName LIKE '%" . $search_data . "%'
                OR User_Email LIKE '%" . $search_data . "%'";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {

                echo "<tr>
                                                        <th scope='row'>" . $row["User_ID"] . "</th>
                                                        <td>" . $row["User_FullName"] . "</td>
                                                        <td>" . $row["User_Email"] . "
                                                        <td>" . $row["User_Type"] . "</td>
                                                        <td>
                                                            <div class='dropdown'>
                                                                <button class='btn btn-primary dropdown-toggle m--3' type='button' id='action-" . $row["User_ID"] ."' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                    Action
                                                                </button>
                                                                <div class='dropdown-menu' aria-labelledby='actionButton'>
                                                                    <a class='dropdown-item edit-data' id='" . $row["User_ID"] ."' data-toggle='modal' data-target='#updateProducts' href='#'>Edit</a>
                                                                    <a class='dropdown-item delete-data' id='" . $row["User_ID"] ."' href='#'>Delete</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>";
            }
        } else {
            echo "<tr><h2 class='subtitle text-red text-center'>It seems that you've not inserted any products yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/><tr/>";
        }
    }

}