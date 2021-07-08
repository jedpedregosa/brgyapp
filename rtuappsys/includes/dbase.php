<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/config.php");

    function connectDb() {
        $conn;
        try {
            $conn = new PDO("mysql:host=localhost;dbname=" . db_name, db_user, db_pw);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $conn;
    }

    function createVisitorId() {
        $conn = connectDb();

        $stmt = $conn->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'rtuappsysdb' AND TABLE_NAME = 'tbl_visitor'");
        $user = $stmt->fetchColumn(); 

        return $user;
    }
?>