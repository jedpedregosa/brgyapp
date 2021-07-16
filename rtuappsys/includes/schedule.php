<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    
    if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        echo json_encode(array("statusCode"=>203)); // User is not sessioned
    } 

    if(isset($_POST["officeCode"]) && isset($_POST["timeCode"]) && isset($_POST["slctDate"])) {
        $slctd_date = $_POST["slctDate"];
        $office = $_POST["officeCode"];
        $time = $_POST["timeCode"];

        $slctd_date = new DateTime($date);
        $submtDate = $slctd_date->format('ymd');

        $officeId = str_replace("RTU-O", "", $office);
        $timeId = str_replace("TMSLOT-", "", $time);
        $schedId = $submtDate . $officeId . $timeId;

        checkTimeSlotValidity($slctd_date, $office, $time, $schedId);
        if(isSchedAvailable($schedId)) {
            echo json_encode(array("statusCode"=>200)); // Schedule is valid
        } else {
            echo json_encode(array("statusCode"=>201)); // Schedule is not valid
        }
    }
    else if(isset($_POST["officeCode"]) && isset($_POST["timeCode"])) {
        echo json_encode(getValues($_POST["officeCode"], $_POST["timeCode"])); 
        // Lacks catch if db fails !!!!!!!!!!!!!!!!
    } else {
        header("Location: ../../main/rtuappsys.php");
        die();
    }
?>