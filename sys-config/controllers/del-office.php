<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		del-office.php (Access Page) -- 
 *  Description:
 * 		1. Deletes an empty (not have an appointment) Office.
 * 
 * 	Date Created: 18th of August, 2021
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

    $office_id;

    if(isset($_GET["off_id"])) {
        $office_id = $_GET["off_id"];
    } else {
        goBack();
    }

    $result = deleteOffice($office_id);
    
    if($result === 301) {
        $_SESSION["off_dltd"] = $office_id;
        goBack(301);
    } else if($result === 300) {
        $_SESSION["off_dltd"] = $office_id;
        goBack(300);
    } else if($result) {
        $_SESSION["off_dltd"] = $office_id;
        $_SESSION["admn_dltd"] = $result;
        goBack(300);
    } else {
        goBack();
    }
    function goBack($errorCode = 303) {
        $_SESSION["off_dltres"] = $errorCode;
        header("Location: ../page/office");
    }
?>