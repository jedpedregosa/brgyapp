<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		load-open-office.php (API, Ajax) -- 
 *  Description:
 * 		1. Loads all the offices that does not have assigned admin.
 * 
 * 	Date Created: 14th of August, 2021
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

    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");

    // Check if request is not from ajax
    if(!IS_AJAX) {
        header("Location: ../main/rtuappsys");
		die();
    }

    if(isset($_POST["branch"])) {
        $campus = $_POST["branch"];

        $offices_without_admin = getUnassignedOffices($campus);
        echo json_encode($offices_without_admin);
    } else {
        // *********** Needs error message
        header("Location: ../main/rtuappsys");
        die();
    }
?>