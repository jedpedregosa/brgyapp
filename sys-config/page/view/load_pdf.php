<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");    

    $appointmentKey;

    if(isset($_GET["app"])) {
        $appointmentKey = $_GET["app"];
    } else {
        exit;
    }
    
    $app_id = getAppointmentIdByAppointmentKey($appointmentKey);
    
	$file_keys = getFileKeysByAppId($app_id);
    $file_dir = APP_FILES . $appointmentKey . "/";

    $original_filename = $file_dir . $file_keys[1] . '.pdf';
	$new_filename = 'RTUAppointment-'. $app_id .'.pdf';

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