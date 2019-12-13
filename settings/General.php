<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/Armor.php';

    if(!(session_status() === PHP_SESSION_ACTIVE)) {
        session_start();
    }

    $CompanyName = "";

    if(isset($_SESSION['email'])) {
        // START: Get Company Name
        $CompanyModal = new CompanyModal();

        $CompanyName = $CompanyModal->getCompanyData("Company_Name");
        // END
    }

    DEFINE("SITE_NAME", $CompanyName);
    DEFINE("ORI_SITE_NAME", "ManageSpace");