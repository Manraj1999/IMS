<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/User.php';

class Admin {

    function getQueueList() {
        $DatabaseHandler = new DatabaseHandler();

        $sql = "SELECT * FROM ims.company_list WHERE `Status` = 'NOT-APPROVED'";
        $connection = $DatabaseHandler->getAdminMySQLiConnection();

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {

                echo "<tr>
                                    <td class=\"text-center\">" . $row["Company_Name"] . "</td>
                                    <td class=\"text-center\">" . $row["Supervisor_Name"] . "</td>
                                    <td class=\"text-center\">" . $row["Email_Address"] . "</td>
                                    <th class=\"text-center text-danger\">Not Approved</th>
                                    <td class=\"text-center\">
                                        <div class='dropdown'>
                                            <button class='btn btn-primary bg-primary dropdown-toggle m--3' type='button' id='action-" . $row["List_ID"] . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Action
                                            </button>
                                            <div class='dropdown-menu' aria-labelledby='actionButton'>
                                                <a class='dropdown-item company-approve' id='" . $row["List_ID"] . "' href='#'>Approve</a>
                                                <a class='dropdown-item company-disapprove' id='" . $row["List_ID"] . "' href='#'>Disapprove</a>
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

    function getCompanyList() {
        $DatabaseHandler = new DatabaseHandler();

        $sql = "SELECT * FROM ims.company_list WHERE `Status` = 'APPROVED'";
        $connection = $DatabaseHandler->getAdminMySQLiConnection();

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {

                echo "<tr>
                                    <td class=\"text-center\">" . $row["Company_Name"] . "</td>
                                    <td class=\"text-center\">" . $row["Supervisor_Name"] . "</td>
                                    <td class=\"text-center\">" . $row["Email_Address"] . "</td>
                                    <th class=\"text-center text-success\">Approved</th>
                                    <td class=\"text-center\">
                                        <div class='dropdown'>
                                            <button class='btn btn-primary bg-primary dropdown-toggle m--3' type='button' id='action-" . $row["List_ID"] . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Action
                                            </button>
                                            <div class='dropdown-menu' aria-labelledby='actionButton'>
                                                <a class='dropdown-item company-access' id='" . $row["List_ID"] . "' href='#'>Access System</a>
                                                <a class='dropdown-item company-change-pass' id='" . $row["List_ID"] . "' data-toggle='modal' data-target='#updateProducts' href='#'>Change Supervisor Password</a>
                                                <a class='dropdown-item company-delete' id='" . $row["List_ID"] . "' href='#'>Delete System</a>
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

    function updateStatus($id, $status) {
        $DatabaseHandler = new DatabaseHandler();
        $User = new User();

        $connection = $DatabaseHandler->getAdminMySQLiConnection();

        if($status == "APPROVED") {
            $sql = "UPDATE ims.company_list SET `Status`='APPROVED' WHERE `List_ID`=$id";

            $results = $connection->query($sql);

            if($results) {

                $getCompanySQL = "SELECT * FROM ims.company_list WHERE List_ID=$id";

                $result = $connection->query($getCompanySQL);

                $companyName = "";
                $userFullName = "";
                $userEmail = "";
                $userSalt = "";

                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $companyName = $row["Company_Name"];
                        $userFullName = $row["Supervisor_Name"];
                        $userEmail = $row["Email_Address"];
                        $userSalt = $row["Password_Salt"];
                    }
                }

                $companyID = strtolower(preg_replace("/[^a-zA-Z]/", "", $companyName));

                $data = array(
                    array("Company_ID", $companyID),
                    array("User_FullName", $userFullName),
                    array("User_Email", $userEmail),
                    array("User_Salt", $userSalt),
                    array("User_Type", "SUPERVISOR")
                );

                $response = $User->register($data, $companyName, "STOCK");
                $message = $User->displayMessage($response, "register");

                if($response['error'] == false) {
                    echo "This company has been approved.";
                } else {
                    echo $message;
                }

            } else {
                echo "There was an issue updating the status of this company.";
            }
        } elseif($status == "DISAPPROVED") {
            $sql = "DELETE FROM ims.company_list WHERE `List_ID`=$id";

            $results = $connection->query($sql);

            if($results) {
                echo "This company has been disapproved.";
            } else {
                echo "There was an issue updating the status of this company.";
            }
        }
    }

    function deleteCompany($id) {
        $DatabaseHandler = new DatabaseHandler();
        $connectionAdmin = $DatabaseHandler->getAdminMySQLiConnection();

        $error = false;
        $Company_ID = "";

        // Get Company_ID
        $getCompanyIDSQL = "SELECT Company_ID FROM ims.company_list WHERE List_ID = $id";
        $result = $connectionAdmin->query($getCompanyIDSQL);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $Company_ID = $row["Company_ID"];
            }

            $sql = "DELETE FROM ims.company_list WHERE `List_ID`=$id";

            $results = $connectionAdmin->query($sql);

            if($results) {
                $error = false;
            } else {
                $error = true;
            }

        }

        if(!$error) {
            // Delete Company Database
            $sql = "DROP DATABASE " . $Company_ID;
            $connection = $DatabaseHandler->getCompanyMySQLiConnection($Company_ID);

            $result = $connection->query($sql);

            if($result) {
                // Remove Supervisor & Users from Main Database
                $remUsersSQL = "DELETE FROM ims.users WHERE Company_ID = '" . $Company_ID . "'";
                $remCompanyListSQL = "DELETE FROM ims.company_list WHERE Company_ID = '" . $Company_ID . "'";

                $remUsersResults = $connectionAdmin->query($remUsersSQL);
                $remCompanyListResults = $connectionAdmin->query($remCompanyListSQL);

                if($remUsersResults && $remCompanyListResults) {
                    $error = false;
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        }

        if($error) {
            echo "There was an error deleting the inventory management system.";
        }
    }

}