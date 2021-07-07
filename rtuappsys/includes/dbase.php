<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/config.php");

    function connectDb() {
        $mysqli = new mysqli("localhost", db_user, db_pw, db_name);

        // Check connection
        if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
        }

        return $mysqli;
    }
?>