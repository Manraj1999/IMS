<?php


class Armor {

    public function initDashboard() {
        if(!(session_status() === PHP_SESSION_ACTIVE)) {
            session_start();
        }

        if(!isset($_SESSION['email'])) {
            header("Location: /ims/index.php");
        }
    }

}