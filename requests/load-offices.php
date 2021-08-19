<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		load-offices.php (API, Ajax) -- 
 *  Description:
 * 		1. Loads all the offices to JSON.
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

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");

    // Check if request is not from ajax
    if(!IS_AJAX) {
        header("Location: ../main/rtuappsys");
		die();
    }

    if(isset($_POST["branch"])) {
        $campus = $_POST["branch"];

        echo json_encode(getOffices($campus));
    } else {
        // *********** Needs error message
        header("Location: ../main/rtuappsys");
        die();
    }
?>