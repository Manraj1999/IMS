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

    function passOwnership($newOwnerID) {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $previousOwnerID = "";
        $previousOwnerEmail = "";
        $newOwnerEmail = "";
        $newOwnerName = "";
        $newSupervisorID = "";

        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));
        $connectionAdmin = $DatabaseHandler->getAdminMySQLiConnection();

        // Get Previous Owner ID
        $sql = "SELECT User_ID FROM users WHERE User_Type = 'SUPERVISOR'";
        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $previousOwnerID = $row["User_ID"];
            }
        }

        // Get current owner and change them to Employee
        $currentOwnerSQL = "SELECT * FROM users WHERE User_ID = " . $previousOwnerID;

        $result = $connection->query($currentOwnerSQL);

        $error = false;

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $previousOwnerEmail = $row["User_Email"];
            }

            // Demote user from Supervisor -> Employee in Company Database
            $demoteSQL = "UPDATE users SET User_Type = 'EMPLOYEE' WHERE User_Email = '$previousOwnerEmail'";
            $resultDemote = $connection->query($demoteSQL);

            if($resultDemote) {
                // Demote user from Supervisor -> Employee in Main Database
                $demoteMainUsersSQL = "UPDATE ims.users SET User_Type = 'EMPLOYEE' WHERE User_Email = '$previousOwnerEmail'";
                $resultDemoteMainUsers = $connectionAdmin->query($demoteMainUsersSQL);

                if(!$resultDemoteMainUsers) {
                    $error = true;
                } else {
                    $error = false;
                }
            } else {
                $error = false;
            }
        }

        // Get new owner and change them to Supervisor

        if($error == false) {
            $newOwnerSQL = "SELECT * FROM users WHERE User_ID = " . $newOwnerID;
            $resultNewOwner = $connection->query($newOwnerSQL);

            if($resultNewOwner->num_rows > 0) {
                while($row = $resultNewOwner->fetch_assoc()) {
                    $newOwnerEmail = $row["User_Email"];
                    $newOwnerName = $row["User_FullName"];
                }

                // Promote user from Employee -> Supervisor in Company Database
                $promoteSQL = "UPDATE users SET User_Type = 'SUPERVISOR' WHERE User_Email = '$newOwnerEmail'";
                $resultPromote = $connection->query($promoteSQL);

                if($resultPromote) {
                    // Promote user from Employee -> Supervisor in Main Database
                    $promoteMainUsersSQL = "UPDATE ims.users SET User_Type = 'SUPERVISOR' WHERE User_Email = '$newOwnerEmail'";
                    $resultPromoteMainUsers = $connectionAdmin->query($promoteMainUsersSQL);

                    if($resultPromoteMainUsers) {
                        // Promote user from Employee -> Supervisor in Main Company List Database
                        $UserModal = new UserModal();
                        $comp_id = $UserModal->getUserData("Company_ID");
                        $promoteMainCompanySQL = "UPDATE ims.company_list SET Supervisor_Name = '$newOwnerName', Email_Address = '$newOwnerEmail' WHERE Company_ID = '$comp_id'";
                        $resultPromoteMainCompany = $connectionAdmin->query($promoteMainCompanySQL);

                        if($resultPromoteMainCompany) {
                            // Update Supervisor ID in company_info table
                            $getNewSupervisorSQL = "SELECT * FROM ims.users WHERE Company_ID = '$comp_id' AND User_Type = 'SUPERVISOR'";
                            $getNewSupervisor = $connectionAdmin->query($getNewSupervisorSQL);

                            if($getNewSupervisor->num_rows > 0) {
                                while($row = $getNewSupervisor->fetch_assoc()) {
                                    $newSupervisorID = $row["User_ID"];
                                }

                                $updateCompanyInfoSQL = "UPDATE company_info SET SU_ID = $newSupervisorID WHERE Company_ID = 1";
                                $updateResult = $connection->query($updateCompanyInfoSQL);

                                if(!$updateResult) {
                                    $error = true;
                                } else {
                                    $error = false;
                                }
                            }
                        } else {
                            $error = true;
                            echo $connectionAdmin->error;
                        }
                    }
                } else {
                    $error = true;
                    echo $connection->error;
                }
            }
        }

        if($error == true) {
            echo "There was an issue when transferring the ownership.";
        } elseif($error == false) {
            echo "Ownership transfer was successful.";
        }
    }

}