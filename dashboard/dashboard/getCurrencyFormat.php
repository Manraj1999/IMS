<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/DatabaseHandler.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';

    session_start();

    $CompanyModal = new CompanyModal();
    echo $CompanyModal->getCompanyData("Currency_Format");