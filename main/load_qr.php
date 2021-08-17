<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		load_qr.php (Access Page) -- 
 *  Description:
 * 		1. Streams the PNG File (QR Code) stored from the secured folder.
 * 
 * 	Date Created: 14th of August, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	
 *  Lacks: Catch if file system fails.
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 ******************************************************************************/

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Schedule.php");

    session_name("cid");
	session_start();

    $appId;

    if(isset($_SESSION["view_email"]) && isset($_SESSION["view_lastname"])) {
        $v_email = $_SESSION["view_email"];
        $v_lname = $_SESSION["view_lastname"];

        if(doesEmailHasAppData($v_email)) {
            $v_app_data = getAppointmentDetailsByEmail($v_email);
            $appId = $v_app_data[0];
        }
    }
    

    $appointmentKey = getAppointmentKeyByAppointmentId($appId);
	$file_keys = getFileKeysByAppId($appId);
    $file_dir = APP_FILES . $appointmentKey . "/";

    $original_filename = $file_dir . $file_keys[0] . '.png';

	// headers to send your file
    header('Content-Description: File Transfer');
    header('Content-Disposition: inline');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
	header("Content-Type: image/png");

	ob_clean();
	flush();

	// upload the file to the user and quit
    readfile($original_filename);
    exit;
?>