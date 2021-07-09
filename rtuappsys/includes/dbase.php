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
            // Catch if db fails
        }
        return $conn;
    }

    function createVisitorId() {
        $conn = connectDb();

        $stmt = $conn->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'rtuappsysdb' AND TABLE_NAME = 'tbl_visitor'");
        $user = $stmt->fetchColumn(); 

        return $user;
    }

    function getValues($officeCode, $timeCode) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_name FROM tbl_office WHERE office_id = ?");
        $stmt-> execute([$officeCode]);
        $officeValue = $stmt->fetchColumn();

        $stmt = $conn->prepare("SELECT CONCAT(tmslot_start, ' - ', tmslot_end) FROM tbl_timeslot WHERE tmslot_id = ?");
        $stmt-> execute([$timeCode]);
        $timeValue = $stmt->fetchColumn();

        // Catch if db fails 
        return array("officeValue"=>$officeValue, "timeValue" => $timeValue);
    }
?>