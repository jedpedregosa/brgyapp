<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");

	$isAlert = false;
	$isSuccess = true;
	$msg;
	$title;

	if(isset($_SESSION["upd_sys_config"])) {
		$val = $_SESSION["upd_sys_config"];
		$isAlert = true;

		if($val == 500) {
			$title = "Username Update";
			$msg = "Change username success.";
		} else if($val == 501) {
			$title = "Cannot Update Username";
			$msg = "Change username failed. The selected username is unavailable.";
		} else if($val == 400) {
			$title = "Updating System Variables";
			$msg = "System Variables was changed successfully.";
		} else if($val == 401) {
			$title = "Updating System Variables Failed";
			$msg = "You can only update system variables if the system is under maintenance.";
		} else if($val == 601) {
			$title = "Change Password Failed";
			$msg = "Your current password does not match.";
		} else if($val == 301) {
			$isAlert = false;
		} else {
			$title = "Error";
			$msg = "Oops, it seems that we have encountered an error. Please try again later.";

			$isSuccess = false;
		}

		unset($_SESSION["upd_sys_config"]);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>System Configuration - RTUAppSys</title>

	<link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/css/SA-SettingsStyle.css" . FILE_VERSION; ?>">
	<link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/css/fnon.min.css" />

	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
					<img src="../assets/img/user-icon.png" id="bar-pic">
				</div>
				<!-- //User Image -->
			</div>
			<!-- //User Image Container -->

			<!-- User Name, Title and Line -->
			<div class="name"><?php echo $config_admin_id; ?></div>
			<div class="job">System Administrator</div>
			<div class="line"></div>
			<!-- //User Name, Title and Line -->

		</div>
		<!-- //User Image Container -->

		<!-- Navigation List -->
		<ul class="nav-list">
			<li>
				<i class="qr"><img src="../assets/img/qr_code_scan.svg"></i>
				<input id="searchQR" type="text" placeholder="Search QR Key..." oninput="Typing()">
				<a href="" onclick='return check(this)'>
					<span class="bi bi-arrow-right-short" id="arrow"></span>
				</a>
				<span class="tooltip">Search QR</span>
			</li>
			<li>
				<a href="main">
					<i class="bi bi-columns-gap"></i>
					<span class="links_name">DASHBOARD</span>
				</a>
				<span class="tooltip">Dashboard</span>
			</li>
			<li>
				<a href="office">
					<i class="bi bi-door-open"></i>
					<span class="links_name">OFFICES</span>
				</a>
				<span class="tooltip">Offices</span>
			</li>
			<li>
				<a href="view/appointment">
					<i class="bi bi-calendar3"></i>
					<span class="links_name">APPOINTMENTS</span>
				</a>
				<span class="tooltip">Appointments</span>
			</li>
			<li>
				<a href="view/feedback">
					<i class="bi bi-star"></i>
					<span class="links_name">FEEDBACK</span>
				</a>
				<span class="tooltip">Feedback</span>
			</li>
			<li>
				<a href="javascript:window.location.reload(true)" class="active">
					<i class="bi bi-gear"></i>
					<span class="links_name">SETTINGS</span>
				</a>
				<span class="tooltip">Settings</span>
			</li>
			<div class="line2"></div>

			<a href = "logout">
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
					<img src="../assets/img/menu.png" id="btn">
					RTU APPOINTMENT SYSTEM
				</div>

				<div class="user-wrapper">
					<!-- User Image Container -->
					<div class="header-user-con">

						<!-- User Image -->
						<div class="header-user-img">
							<img src="../assets/img/user-icon.png" id="header-pic">
						</div>
						<!-- //User Image -->
					</div>
					<!-- //User Image Container -->

					<div class="user-name">
						<a href="javascript:window.location.reload(true)"><h5><?php echo $config_admin_id; ?></h5></a>
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

			<!-- Page Title -->
			<div class="page-title">
				System Configuration
			</div>
			<!-- //Page Title -->

			<!-- Tabs -->
			<div class="tabs">
				<!-- Tab Header -->
				<div class="tab-header">
					<div class="active_tab">
						<i class="bx bx-user"></i> <span class="headerTab">Account Settings</span>
					</div>
					<div>
						<i class="bi bi-laptop"></i> <span class="headerTab">System Settings</span>
					</div>
				</div>
				<!-- //Tab Header -->
				<div class="tab-indicator"></div>
				<div class="tab-line"></div>

				<!-- Tab Body Contents-->
				<div class="tab-body">
					<!-- Account Information -->
					<div class="active_tab">
						<h3>Configuration Account Information</h3>

						<!-- User Image Container -->
						<div class="profile-user-div">
							<!-- User Image -->
							<div class="profile-user-img">
								<img src="../assets/img/user-icon.png" id="profile-photo">
							</div>
							<!-- //User Image -->
						</div>
						<!-- //User Image Container -->
						
						<!-- Admin Name and Job Title -->
						<div class="admin_name"><?php echo $config_admin_id; ?></div>
						<div class="admin_title">System Administrator</div>
						<!-- Admin Name and Job Title -->

						<!-- User Profile Info -->
						<div class="user-infos">	
							<div class="info-fields">

								<!-- Username Form -->
								<form action="../controllers/edit-uname" method="POST">
									<i class="bi bi-person"></i>
									<label>Username</label>
									<input type="text" id="username" name ="username" maxLength = "15" class="userName" placeholder="Username" 
										value = "<?php echo $config_admin_id; ?>" autocomplete="off" required readonly>

									<!-- Edit and Update Button -->
									<button type="button" id="editBtn"><i class="bi bi-pencil-square"></i> Edit Username</button>
									<!-- //Edit and Update Button -->

									<!-- Username Strength Checker -->
								    <div id="Umess">
										<span id="upperU">
										    <i class="bi bi-check-lg"></i>
										    Uppercase letter
										</span><br>

										<span id="lowerU">
										    <i class="bi bi-check-lg"></i>
										    Lowercase letter
										</span><br>

										<span id="digitU">
										    <i class="bi bi-check-lg"></i>
										    At least 1 number
										</span><br>

										<span id="specialU">
										    <i class="bi bi-check-lg"></i>
										    At least 1 special character
										</span><br>

										<span id="lenU">
										    <i class="bi bi-check-lg"></i>
										    At least 12 characters long
										</span>
							      	</div>
							      	<!-- //Username Strength Checker -->

							      </form>
							      <!-- //Username Form -->

							</div>
							
							<!-- Change Password Button -->
							<div class="changePassBtn" id="changeBtn">
								<i class="bi bi-key"></i>
								Change Password
							</div>
							<!-- //Change Password Button -->

							<!-- Change Password Form Div -->
							<div id="change_pass_form">

								<!-- Change Password Form -->
								<form class="passwordForm" action="../controllers/chng-pass" method="POST">

									<!-- Current Password -->
									<div class="column">
										<label>Current Password</label>
										<input type="password" placeholder="Enter current password" name="currentPassword" id="currentPassword" autocomplete="off" required>

										<!-- Show Password -->
							      		<span class="show">
								      		<i class="bi bi-eye" id="show1" onclick="toggle1()"></i>  
							  	  		</span>
							  	  		<!-- //Show Password -->

									</div>
									<!-- //Current Password -->


									<!-- New Password -->
									<div class="column">
										<label for="newPassword">New Password</label>
			      						<input type="password" placeholder="Enter new password" name="newPassword" id="newPassword" autocomplete="off" onkeyup="password()" required>

										<!-- Show Password -->
							      		<span class="show">
								      		<i class="bi bi-eye" id="show2" onclick="toggle2()"></i>  
							  	  		</span>
							  	  		<!-- //Show Password -->

							  	  		<!-- New Password Strength Checker -->
							      		<div id="mess">
									      	<span id="upper">
									      		<i class="bi bi-check-lg"></i>
									      		Uppercase letter
									      	</span><br>

									      	<span id="lower">
									      		<i class="bi bi-check-lg"></i>
									      		Lowercase letter
									      	</span><br>

									      	<span id="digit">
									      		<i class="bi bi-check-lg"></i>
									      		At least 1 number
									      	</span><br>

									      	<span id="special">
									      		<i class="bi bi-check-lg"></i>
									      		At least 1 special character
									      	</span><br>

									      	<span id="len">
									      		<i class="bi bi-check-lg"></i>
									      		At least 12 characters long
									      	</span>
						      			</div>
						      			<!-- //New Password Strength Checker -->

			      					</div>
			      					<!-- //New Password -->

			      					<!-- Confirm New Password -->
			      					<div class="column">
			      						<label for="cNewPassword">Confirm New Password</label>
		      							<input type="password" placeholder="Re-enter new password" name="cNewPassword" id="cNewPassword" autocomplete="off" onkeyup="valid()" required>

		      							<!-- Show Password -->
							      		<span class="show">
								      		<i class="bi bi-eye" id="show3" onclick="toggle3()"></i>  
							  	  		</span>
							  	  		<!-- //Show Password -->

							  	  		<!-- Alert Message if password match and filled out -->
					      				<div id="alertMessage"></div>
					      				<!-- //Alert Message if password match and filled out -->
		      						</div>
		      						<!-- //Confirm New Password -->

		      						<!-- Buttons -->
	      							<button type="reset" id="cancelBtn">Cancel</button>
	      							<button type="submit" id = "submtBtn">Update Password</button>
	      							<!-- //Buttons -->

								</form>
								<!-- //Change Password Form -->

							</div>
							<!-- //Change Password Form Div -->

						</div>
						<!-- //User Profile Info -->

					</div>
					<!-- //Account Information -->


					<!-- System Information -->
					<div class="system_tab">
						<h3>System Variables</h3>

						<h4>Maintenance Mode</h4>

						<!-- Toggle Button or Swicth -->
						<form id = "frm-mntn" action = "../controllers/set-maintain" method = "POST">
							<div class="toggle-btn">
									<input type="checkbox" id="toggle-btn" name = "btn_main" <?php if($is_under_maintenance) echo "checked";?>>
								<label for="toggle-btn">
									<div class="flip"></div>
								</label>
							</div>
						</form>
						<!-- //Toggle Button or Swicth -->

						<div class="row">

							<!-- Form -->
							<form action="../controllers/chng-sysvar" method="POST">
								<div class="col">
									<label>Visitor Per Timeslot</label>
									<input name="max_visitor" id="visitor" type="number" min="5" max="9" onblur="validateVisitor();" placeholder="Limit: 5-9 Visitors only" value = "<?php echo max_per_sched; ?>" required>

									<label>The span of open days to reschedule an appointment</label>
									<input name="days_resched" id="days_resched" type="number" min="1" max="5" onblur="validateResched();" placeholder="Limit: 1-5 Days only" value = "<?php echo days_rescheduling_span; ?>" required>

									<label>Number of days open for scheduling</label>
									<input name="days_span" id="days_span" type="number" min="15" max="90" onblur="validateDays();" placeholder="Limit: 15-90 Days only" value = "<?php echo days_scheduling_span; ?>" required>

								</div>

								<div class="col">
									<span class="label"><b>For same-day appointments:</b></span>

									<label>The span of hours the timeslot is open for scheduling</label>
									<input name="hours_span" id="hours_span" type="number" min="1" max="24" onblur="validateHours();" placeholder="Limit: 1-24 Hours only" value = "<?php echo hours_scheduling_span; ?>" required>

									<!-- Update Button -->
									<button id="submitBtn" name = "upd_sysvar" type="submit">Update System Settings</button>
									<!-- //Update Button -->

								</div>
							</form>
							<!-- //Form -->

							<!-- View System Logs Button -->
							<button id="viewBtn" onclick="location.href='download/all-sys-log?month=1'">View System Activities This Month</button>
							<button id="viewBtn" onclick="location.href='download/all-sys-log'">View All System Logs</button>
							<!-- //View System Logs Button -->

						</div>
					</div>
					<!-- //System Information -->

				</div>
				<!-- Tab Body Contents-->

			</div>
			<!-- //Tabs -->

		</div>
		<!-- //Contents Container -->

	</main>
	<!-- //Contents -->

	<!-- Javascript -->
	<script src="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/js/SA-SettingsScript.js" . FILE_VERSION; ?>"></script>
	<script src="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/js/fnon.min.js"></script>
	<?php 
		if($isAlert) {
			if($isSuccess) {
				echo "<script> Fnon.Alert.Warning({
					message: '". $msg ."',
					title: '" . $title . "',
					btnOkText: 'Okay',
					btnOkColor: 'White',
					btnOkBackground: '#002060',
					fontFamily: 'Poppins, sans-serif'
				}); </script>";
			} else {
				echo "<script> Fnon.Alert.Danger({
					message: '". $msg ."',
					title: '" . $title . "',
					btnOkText: 'Okay',
					fontFamily: 'Poppins, sans-serif'
				}); </script>";
			}
		} else {
			if($is_under_maintenance) {
				echo "<script> Fnon.Alert.Dark({
					message: 'The system is still under maintenance mode. All users except system administrators are still prohibited to use the system.',
					title: '<strong>Reminder</strong>',
					btnOkText: 'Okay',
					fontFamily: 'Poppins, sans-serif'
				}); </script>";
			}
		}
	?>

	<!-- //Javascript -->

</body>
</html>