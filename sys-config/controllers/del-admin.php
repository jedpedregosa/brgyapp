<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		del-admin.php (Access Page) -- 
 *  Description:
 * 		1. Deletes an office admin.
 * 
 * 	Date Created: 19th of August, 2021
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

session_name("cid");
session_start();

$admin_id;

if(isset($_GET["adm_id"])) {
    $admin_id = $_GET["adm_id"];
} else {
    goBack();
}

$result = deleteOfficeAdmin($admin_id);

if($result) {
    $_SESSION["admn_dltd"] = $admin_id;
    goBack(302);
} else {
    goBack();
}
function goBack($errorCode = 303) {
    $_SESSION["off_dltres"] = $errorCode;
    header("Location: ../page/office");
}
?>