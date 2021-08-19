<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		load-slots.php (API, Ajax) -- 
 *  Description:
 * 		1. Loads all the available timeslots to JSON.
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

    if(isset($_POST["date"]) && isset($_POST["office"])) {
        $slctDate = $_POST["date"];
        $slctOffice = $_POST["office"];
    } else if(isset($_POST["view_date"]) && isset($_SESSION["view_office"])) {
        $slctDate = $_POST["view_date"];
        $slctOffice = $_SESSION["view_office"];
    } else {
        // *********** Needs error message
        header("Location: ../main/rtuappsys");
        die();
    }

    $availableSlots = [];

    $slctd_date = new DateTime($slctDate);
    $checkDate = $slctd_date->format('ymd');
    $officeId = str_replace("RTU-O", "", $slctOffice);

    for($i = 1; $i <= (int)number_of_timeslots; $i++) {
        $timeId = $i <= 9 ? "0" . $i : $i;
        $schedId = $checkDate . $officeId . $timeId;
       
        $slot = "TMSLOT-" . $timeId;
        checkTimeSlotValidity($slctDate, $slctOffice, $slot, $schedId);
        array_push($availableSlots, [$slot, isSchedAvailable($schedId)]);

    }
    echo json_encode($availableSlots);

?>