<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';

class Orders {

    function getOrders() {
        $DatabaseHandler = new DatabaseHandler();
        $UserModal = new UserModal();

        $CompanyModal = new CompanyModal();

        $sql = "SELECT * FROM orders";
        $connection = $DatabaseHandler->getCompanyMySQLiConnection($UserModal->getUserData("Company_ID"));

        $results = $connection->query($sql);

        if($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {

                $Product_Name = "";

                $getProductNameSQL = "SELECT Product_Name FROM products WHERE Product_ID=" . $row["Product_ID"];
                $resultsProductName = $connection->query($getProductNameSQL);

                if($resultsProductName->num_rows > 0) {
                    while($rowProduct = $results->fetch_assoc()) {
                        $Product_Name = $rowProduct["Product_Name"];
                    }
                }

                echo "<tr>
                                                        <th scope='row'>" . $row["Order_ID"] . "</th>
                                                        <td>$Product_Name</td>
                                                        <td>" . $row["Customer_Name"] . "
                                                        <td>" . $row["Product_Quantity"] . "</td>
                                                        <td>" . $CompanyModal->getCompanyData("Currency_Format") . $row["Total_Amount"] . "</td>
                                                        <td>" . $row["Order_Date"] . "</td>
                                                    </tr>";
            }
        } else {
            echo "<div class='align-content-center'><h2 class='subtitle text-green text-center'>There seems to be no orders yet...</h2>
                                            <img src='../assets/img/theme/not-found.gif' class='gif'/></div>";
        }
    }

}