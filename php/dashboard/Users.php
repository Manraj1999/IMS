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

                $deleteString = "";
                $changeSupervisorString = "";

                if($row["User_Type"] !== "SUPERVISOR") {
                    $deleteString = "<a class='dropdown-item delete-data' id='" . $row["User_ID"] . "' href='#'>Delete</a>";
                    $changeSupervisorString = "<a class='dropdown-item pass-ownership-data' id='" . $row["User_ID"] . "' href='#'>Pass Ownership</a>";
                }

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
                                                                    <a class='dropdown-item change-pass' id='" . $row["User_ID"] ."' data-toggle='modal' data-target='#updatePassword' href='#'>Change Password</a>
                                                                    $changeSupervisorString
                                                                    $deleteString
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>";
            }
        } else {
            echo "<div class='align-content-center'><h2 class='subtitle text-green text-center'>It seems that you've not inserted any users yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/></div>";
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

        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {

                $deleteString = "";

                if ($row["User_Type"] !== "SUPERVISOR") {
                    $deleteString = "<a class='dropdown-item delete-data' id='" . $row["User_ID"] . "' href='#'>Delete</a>";
                }

                echo "<tr>
                                                        <th scope='row'>" . $row["User_ID"] . "</th>
                                                        <td>" . $row["User_FullName"] . "</td>
                                                        <td>" . $row["User_Email"] . "
                                                        <td>" . $row["User_Type"] . "</td>
                                                        <td>
                                                            <div class='dropdown'>
                                                                <button class='btn btn-primary dropdown-toggle m--3' type='button' id='action-" . $row["User_ID"] . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                    Action
                                                                </button>
                                                                <div class='dropdown-menu' aria-labelledby='actionButton'>
                                                                    <a class='dropdown-item change-pass' id='" . $row["User_ID"] . "' data-toggle='modal' data-target='#updatePassword' href='#'>Change Password</a>
                                                                    $deleteString
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>";
            }
        } else {
            echo "<div class='align-content-center'><h2 class='subtitle text-green text-center'>It seems that you've not inserted any users yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/></div>";
        }
    }

    function passOwnership($previousOwnerID, $newOwnerID) {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        // Get current owner and change them to Employee
        $currentOwnerSQL = "SELECT * FROM users WHERE User_ID = " . $previousOwnerID;
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $result = $connection->query($currentOwnerSQL);

        // Get new owner and change them to Supervisor

    }

}