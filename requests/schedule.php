<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		schedule.php (API, Ajax) -- 
 *  Description:
 * 		1. Checks if a schedule is still avaliable
 * 
 * 	Date Created: 30th of July, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	
 *  Lacks: 
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 ******************************************************************************/

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    // Check if request is not from ajax
    if(!IS_AJAX) {
        header("Location: ../main/rtuappsys");
		die();
    }
    
    // Session Side
    session_name("cid");
    session_start();

    if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        echo json_encode(array("statusCode"=>203)); // User is not sessioned
    } 

    if(isset($_POST["officeCode"]) && isset($_POST["timeCode"]) && isset($_POST["slctDate"])) {
        $date = $_POST["slctDate"];
        $office = $_POST["officeCode"];
        $time = $_POST["timeCode"];

        $slctd_date = new DateTime($date);
        $submtDate = $slctd_date->format('ymd');

        $officeId = str_replace("RTU-O", "", $office);
        $timeId = str_replace("TMSLOT-", "", $time);
        $schedId = $submtDate . $officeId . $timeId;

        checkTimeSlotValidity($date, $office, $time, $schedId);
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
        header("Location: ../../main/rtuappsys");
        die();
    }
?>