<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		load-dates.php (API, Ajax) -- 
 *  Description:
 * 		1. Loads all the available dates to JSON.
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

    if(isset($_POST['officeCode'])) {
        $office = $_POST['officeCode'];
    } else {
        // *********** Needs error message
        header("Location: ../main/rtuappsys");
        die();
    }

    date_default_timezone_set("Asia/Manila");
    $slctd_date = new DateTime();
    $startDate = $slctd_date->format('Y-m-d');

    $availableDates = [];

    $date = $startDate;
    $i = 1;
    while($i <= (int)days_scheduling_span) {
        if(!(date('N', strtotime($date)) >= 6)) {
            if(checkDaySched($date, $office)) {
                array_push($availableDates, $date);
                $i += 1;
            }
        }
        $date = date('Y-m-d', strtotime($date. ' + 1 days'));
    }
    echo json_encode($availableDates);

?>