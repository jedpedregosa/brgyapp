<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		load_pdf.php (Access Page) -- 
 *  Description:
 * 		1. Streams the PDF (Appointment Slip) stored from the secured folder.
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

    $appId;

    session_name("id");
	session_start();

    if(isset($_SESSION["applicationId"])) {
        $appId = $_SESSION["applicationId"];
    } else {
        header("Location: rtuappsys");
		die();
    }

    $appointmentKey = getAppointmentKeyByAppointmentId($appId);
	$file_keys = getFileKeysByAppId($appId);
    $file_dir = APP_FILES . $appointmentKey . "/";

    $original_filename = $file_dir . $file_keys[1] . '.pdf';
	$new_filename = 'RTUAppointment-'. $appId .'.pdf';

	// headers to send your file
    header('Content-Description: File Transfer');
    header('Content-Disposition: inline');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
	header("Content-Type: application/pdf");

	ob_clean();
	flush();

	// upload the file to the user and quit
    readfile($original_filename);
    exit;
?>