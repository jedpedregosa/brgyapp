<?php 

/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		your-appointment.php (Web Page) -- 
 *  Description:
 * 		1. Displays the PDF resulted file of the whole
 * 			appointment scheduling system.
 * 		2. Generates the QR-Code, linking to the appointment
 * 			result.
 * 
 * 	Date Created: 7th of July, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 * **************************************************************************/

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/api/phpqrcode/qrlib.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/create-pdf.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    $appId;

    session_name("id");
	session_start();

	if(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"])) {
        unset($_SESSION['userId']);
		unset($_SESSION['uLname']);
		unset($_SESSION['uType']);
    } 
    // Initialization

    if(isset($_SESSION["applicationId"])) {
        $appId = $_SESSION["applicationId"];
    } else {
        header("Location: rtuappsys");
		die();
    }

	checkAppointmentValidity($appId);

	if(!doesAppointmentExists($appId)) {
		header("Location: rtuappsys");
		die();
	}
	
	$appointmentKey = getAppointmentKeyByAppointmentId($appId);
	$file_keys = getFileKeysByAppId($appId);

	$file_dir = APP_FILES . $appointmentKey . "/";
	if(!is_dir($file_dir)) {
		mkdir($file_dir);
	}

    $flname = $file_keys[0] . ".png";
    $qrfilepath = $file_dir . $flname;

    if (!file_exists($qrfilepath)) {
        QRcode::png(HTTP_PROTOCOL . $_SERVER['HTTP_HOST' ]. "/rtuappsys/direct?an_=". $appointmentKey, $qrfilepath); //should be a default link
    }
	$visitor_data = getVisitorDataByAppointmentId($appId);
	
	if(!file_exists($file_dir . $file_keys[1] .'.pdf')) {
		generateAppointmentFile($appId);
	}

	if(isset($_GET["dl"])) {
		$original_filename = $file_dir . $file_keys[1] . '.pdf';
		$new_filename = 'RTUAppointment-'. $appId .'.pdf';

		// headers to send your file
		header("Content-Type: application/pdf");
		header("Content-Disposition: attachment; filename=" . $new_filename );

		ob_clean();
		flush();

		// upload the file to the user and quit
		readfile($original_filename);
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Thank You!</title>

	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_PROTOCOL . HOST . "/assets/css/PDFStyle.css" . FILE_VERSION ?>">
</head>
<body>
	<!-- HEADER -->
	<div class="headerBG">
		<img src="../assets/img/header2.png">
	</div>
	  
	<div class="logoHeader">
		<img src="../assets/img/rtu_logo.png">
	</div>
	<!-- //HEADER -->

	<!-- CONTENTS -->
	<div class="main">

		<!-- ROW -->
		<div class="row">

			<!-- COLUMN 1 -->
			<div class="col-1">

				<!-- THANK YOU -->
				<div class="thankYou">
					<p>Thank you, <span><?php echo htmlspecialchars($visitor_data[3]); ?></span>!</p><!-- PUT USER'S NAME INSIDE THE SPAN TAG -->
				</div>
				<!-- //THANK YOU -->
				
				<!-- PDF DIV -->
				<div class="pdf">
					<!-- PUT HERE THE PDF VIEWER OR DOWNLOADER -->
					<object data="load_pdf" type="application/pdf" width="100%" height="100%">
                        <embed src="load_pdf" type="application/pdf" />
                    </object>
				</div>
				<!-- //PDF DIV -->
                
				<!-- SEE YOU IN RTU -->
				<div class="seeYou">
					<p><span>You can </span> download it <a href="your-appointment?dl=1" >here</a> instead.</p>
					<p>See you in <span>Rizal Technological University</span>!</p>
				</div>
				<!-- //SEE YOU IN RTU -->

			</div>
			<!-- //COLUMN 1 -->

			<!-- COLUMN 2 -->
			<div class="col-2">
				<img src="../assets/img/frontgp.png" class="handBG">
				<div class="color-box"></div>
			</div>
			<!-- //COLUMN 2 -->

		</div>
		<!-- //ROW -->
	</div>

	<!-- DESIGN -->
	<div class="design">
		<img src="../assets/img/design.png">
	</div>
	<!-- //DESIGN -->

	<!-- //CONTENTS -->

	<!-- FOOTER -->
	<div class="footer">
		<div class="footer-bottom">
		COPYRIGHT &copy; 2021 RIZAL TECHNOLOGICAL UNIVERSITY<!-- COPYRIGHT -->
		</div>
	</div>
	<!-- //FOOTER -->
</body>
</html>
