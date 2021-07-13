<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/phpqrcode/qrlib.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/create-pdf.php");

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
        header("Location: rtuappsys.php");
		die();
    }
    $flname = $appId . ".png";
    $qrLoc = $_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/assets/img/source/";
    $qrfilepath = $qrLoc . $flname;

    if (!file_exists($qrfilepath)) {
        QRcode::png($_SERVER['HTTP_HOST' ]. "/rtuappsys/main/check-appointments.php?app_id=". $appId, $qrfilepath); //should be a default link
    }
	$visitor_data = getVisitorDataByAppointmentId($appId);
	
	if(!file_exists($_SERVER['DOCUMENT_ROOT'] . '/rtuappsys/assets/files/RTUAppointment'. $appId .'.pdf')) {
		generateAppointmentFile($appId);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Thank You!</title>

	<link rel="stylesheet" href="../assets/css/PDFStyle.css">
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
					<object data="../assets/files/RTUAppointment<?php echo $appId ?>.pdf" type="application/pdf" width="100%" height="100%">PDF Error</object>
				</div>
				<!-- //PDF DIV -->
                
				<!-- SEE YOU IN RTU -->
				<div class="seeYou">
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