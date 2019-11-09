<?php

class CompanyModal {

    /**
     * @param mixed getCompanyData(DataType) - Company_ID, SU_ID, Company_Name, Company_Location, Minimum_Threshold, Maximum_Threshold
     * @return string Returns the data from the database
     */
    public function getCompanyData($DataType) {
        $data = "";
        $company_ID = "";

        // Connect to Database
        $DatabaseHandler = new DatabaseHandler();
        $connection = $DatabaseHandler->getMySQLiConnection();

        $sql = "SELECT Company_ID FROM users WHERE User_Email = '" . $_SESSION['email'] . "'";
        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $company_ID = $row["Company_ID"];
            }
        }

        $companyConnection = $DatabaseHandler->getCompanyMySQLiConnection($company_ID);
        $sqlCompany = "SELECT " . $DataType . " FROM company_info WHERE Company_ID = 1";
        $resultsCompany = $companyConnection->query($sqlCompany);

        if($resultsCompany->num_rows > 0) {
            while($row = $resultsCompany->fetch_assoc()) {
                $data = $row[$DataType];
            }
        }
        return $data;
    }

    public function getCompanySupervisorData($DataType) {
        $data = "";

        // Get SU_ID From Company
        $SU_ID = $this->getCompanyData("SU_ID");

        // Connect to Database
        $DatabaseHandler = new DatabaseHandler();
        $connection = $DatabaseHandler->getMySQLiConnection();

        $sql = "SELECT " . $DataType . " FROM ims.users WHERE User_ID = '" . $SU_ID . "'";
        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $data = $row[$DataType];
            }
        }
        return $data;
    }
}