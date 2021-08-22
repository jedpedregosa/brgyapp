<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");

    $appointment_key;

    $first_label;
    $second_label = "Email Address";
    $isGuest = false;

    if(isset($_GET["app_"])) {
        $appointment_key = $_GET["app_"];
    } else if(isset($_GET["qr_key"])){
        $qr_key = $_GET["qr_key"];
		$appointment_key = getAppointmentKeyByQr($qr_key);
    } else {
		header("Location: ../main");
        die();
	}

	if(!isAppKeyValid($appointment_key)) {
		goBack();
	}

    $app_id = getAppointmentIdByAppointmentKey($appointment_key);
    $appointment_data = arrangeAppointmentData($app_id);
	$app_office_id = getAppointmentOffice($app_id);

    $type = $appointment_data[0];
 
    if($type == "guest") {
        $first_label = "Email Address";
        $second_label = "Type of ID";
        $isGuest = true;
    } else if($type == "student") {
        $first_label = "Student Number";
    } else {
        $first_label = "Employee Number";
    }

    $file_keys = getFileKeysByAppId($app_id);

	function goBack($errorCode = 302) {
		$_SESSION["err_config_admin"] = $errorCode;
		header("Location: ../main");
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Appointment - <?php echo htmlspecialchars($app_id); ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/css/QRStyle.css" . FILE_VERSION ?>">
	<link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/css/fnon.min.css" />

	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
	<!-- Side Navigation Bar -->
	<div class="sidebar">

		<!-- User Image Container -->
		<div class="user-con">

			<!-- User Image Container -->
			<div class="user-img">
				<!-- User Image -->
				<div class="bar-user-img">
				<img src="load_image" id="bar-pic" alt="Not Found" onerror="this.src='../../assets/img/user-icon.png'">
				</div>
				<!-- //User Image -->
			</div>
			<!-- //User Image Container -->

			<!-- User Name, Title and Line -->
			<div class="name"><?php echo $config_admin_id; ?></div>
			<div class="job">Administrator</div>
			<div class="line"></div>
			<!-- //User Name, Title and Line -->

		</div>
		<!-- //User Image Container -->

		<!-- Navigation List -->
		<ul class="nav-list">
			<li>
				<a href="../main">
					<i class="bi bi-arrow-left-square-fill"></i>
					<span class="links_name">BACK</span>
				</a>
				<span class="tooltip">BACK</span>
			</li>

			<div class="line2"></div>

			<a href = "../logout">
                <li class="logout">
                    <i class='bi bi-box-arrow-right' id="log_out"></i>
                    <span class="logout-label">Logout</span>
                </li>
            </a>
		</ul>
		<!-- //Navigation List -->

	</div>
	<!-- //Side Navigation Bar -->

	<!-- Header -->
	<section class="header-section">
		<div class="header-border">
			<div class="header">
				<div class="sys-title">
					<img src="../../assets/img/menu.png" id="btn">
					RTU APPOINTMENT SYSTEM
				</div>

				<div class="user-wrapper">
					<!-- User Image Container -->
					<div class="header-user-con">

						<!-- User Image -->
						<div class="header-user-img">
							<img src="../../assets/img/user-icon.png">
						</div>
						<!-- //User Image -->
					</div>
					<!-- //User Image Container -->

					<div class="user-name">
						<a href="../sys-settings"><h5><?php echo $config_admin_id; ?></h5></a><!-- Connect to Profile -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- //Header -->

	<!-- Contents -->
	<main>
		<!-- Contents Container -->
		<div class="contents">
			<span class="page_name">
				<i class="bi bi-info-circle-fill"></i>&ensp;Appointment Details
			</span>

			<!-- Appointment Details -->
			<div class="appt">
				<div class="details left">
					<ul>
						<li>PERSONAL INFORMATION</li>

						<div class="personal">
							<div class="column per1">
                            	<label><?php echo htmlspecialchars($first_label); ?></label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[2]); ?></span><!-- Data -->

								<label>Full Name</label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[3]); ?></span><br><!-- Data -->
							</div>
							
							<div class="column per2">
								<label>Contact Number</label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[4]); ?></span><br><!-- Data -->

								<label><?php echo htmlspecialchars($second_label); ?></label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[5]); ?></span><!-- Data -->
							</div>
							
						</div><br>

						<li>APPOINTMENT INFORMATION</li>

						<div class="appointment">
							<div class="column app1">
								<label>RTU Branch</label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[6]); ?></span><br><!-- Data -->

								<label>Office Name</label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[8]); ?></span><br><!-- Data -->

								<label>Purpose</label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[10]); ?></span><!-- Data -->
							</div>
							
							<div class="column app2">
								<label>Date</label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[7]); ?></span><br><!-- Data -->

								<label>Time</label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[9]); ?></span><br><!-- Data -->
                    <?php
                        if($isGuest) {
                            ?>
								<label>Gov't ID</label>
								<span class="inputs"><?php echo htmlspecialchars($appointment_data[11]); ?></span><!-- Data -->
                            <?php
                        }
                    ?>
							</div>
						</div>
					</ul>
				</div>

				<div class="details right">
					<ul>
						<li>APPOINTMENT SLIP</li>
					</ul>
					<div class="pdf">
						<!-- Put here the pdf -->
                        <object data="load_pdf?app=<?php echo $appointment_key?>" type="application/pdf" width="100%" height="100%">
                            <embed src="load_pdf?app=<?php echo $appointment_key?>" type="application/pdf" />
                        </object>
					</div>
				</div>
			</div>
			<!-- //Appointment Details -->
		</div>
		<!-- Contents Container -->
	</main>
	<!-- //Contents -->

	<!-- Javascript -->
	<script src="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/js/QRScript.js" . FILE_VERSION; ?>"></script>
	<script src="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/js/fnon.min.js"></script>
	<!-- //Javascript -->
	<?php 
        if($is_under_maintenance) {
            echo "<script> Fnon.Alert.Dark({
                message: 'The system is still under maintenance, all users except system administrators are still prohibited to use the system.',
                title: '<strong>Reminder</strong>',
                btnOkText: 'Okay',
                fontFamily: 'Poppins, sans-serif'
            }); </script>";
        }
    ?>
</body>
</html>
