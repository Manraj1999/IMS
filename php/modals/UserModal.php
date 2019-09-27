<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/DatabaseHandler.php";

class UserModal {

    /**
     * @param mixed getUserData(DataType) - User_ID, Company_ID, User_FullName, User_Email, User_Salt, User_Type
     * @return string Returns the data from the database
     */
    public function getUserData($DataType) {
        $data = "";

        // Connect to Database
        $DatabaseHandler = new DatabaseHandler();
        $connection = $DatabaseHandler->getMySQLiConnection();

        $sql = "SELECT " . $DataType . " FROM ims.users WHERE User_Email = '" . $_SESSION['email'] . "'";
        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $data = $row[$DataType];
            }
        }
        return $data;
    }

}