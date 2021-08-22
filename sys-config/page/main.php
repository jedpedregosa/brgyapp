<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");

	$app_today = totalAppointmentToday();
	$app_week = totalAppointmentOfWeek();
	$app_month = totalAppointmentOfMonth();

	$feedback_view = getTwoFeedBack();
	$feedback_size = sizeof($feedback_view);

	$isAlert = false;
	if(isset($_SESSION["err_config_admin"])) {
		$isAlert = true;
		if($_SESSION["err_config_admin"] == 302) {
			$title = "Not Found";
            $message = "Oops, this appointment cannot be found.";
		}
		unset($_SESSION["err_config_admin"]);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Dashboard</title>

	<link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/css/SA-DashboardStyle.css" . FILE_VERSION; ?>">
	<link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/css/fnon.min.css" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
			<div class="job">Administrator</div>
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
				<a href="javascript:window.location.reload(true)" class="active">
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
				<a href="sys-settings">
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
						<a href="sys-settings"><h5><?php echo $config_admin_id; ?></h5></a>
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
				DASHBOARD
			</div>
			<!-- //Page Title -->

	        <!-- Appointment Container -->
	        <section class="appointment-container"> 
	        	<!-- Grid Position of Current Day Box -->
	            <div class="top-box total-box-today">
	            	<!-- Blue Border (#002060) on the left side of the box -->
	                <div class="vertical-line ">
	                	<!-- Font style uniform -->
	                    <div class="font-uniform">
	                        <h4> TOTAL APPOINTMENT TODAY&emsp;&ensp;&ensp;&ensp;&nbsp;</h4>
	                    </div><br>
	                    <!-- //Font style uniform -->

	                    <!-- Display of Appointment Total Number -->
	                    <div class="overview-total">
							<div><h4 class="total"><?php echo htmlspecialchars($app_today); ?> </h4></div> <!-- Display Data (Show total number of appointment today)-->
							<div><a href="view/appointment?by=today" class="bi bi-clipboard-data"></a></div> <!-- Link for redirection to appointment-->
						</div>
						<!-- //Display of Appointment Total Number -->
	                </div>
	                <!-- //Blue Border (#002060) on the left side of the box -->
	            </div>
	            <!-- //Grid position of current day box -->
	            
	            <!-- Grid position of current WEEK box -->
	            <div class="top-box total-box-week">
	            	<!-- //Blue Border (#002060) on the left side of the box -->
	                <div class="vertical-line ">
	                    <div class="font-uniform">
	                        <h4>TOTAL APPOINTMENT THIS WEEK </b>&nbsp;</h4> 
	                    </div><br>
	                    <div class="overview-total">
							<div><h4 class="total"> <?php echo htmlspecialchars($app_week);?> </h4></div> <!-- Display Data (Show total number of appointment this week)-->
							<div><a href="view/appointment?by=week" class="bi bi-clipboard-data"></a></div> <!-- Link for redirection to appointments -->
						</div>
	                </div>
	            </div>
	            <!-- //Grid position of current week box -->

	            <!-- Grid position of current MONTH box -->
	            <div class="top-box total-box-month">
	                <div class="vertical-line ">
	                    <div class="font-uniform">
	                        <h4>TOTAL APPOINTMENT THIS MONTH </h4>
	                    </div><br>
	                    <div class="overview-total">
							<div><h4 class="total"> <?php echo htmlspecialchars($app_month); ?> </h4></div> <!-- Display Data (Show total number of appointment this month)-->
							<div><a href="view/appointment" class="bi bi-clipboard-data"></a></div> <!-- Link for redirection to appointments -->
						</div>
	                </div>
	            </div>
	            <!-- Grid position of current month box -->

	            <!-- Grid position of FOOTER box -->
	            <div class="footer">
	                <header class="header">
	                    <div class="logo">
	                        <img src="../assets/img/rtu_logo.png"/>
	                        <div class="label-footer">
	                            <span style="color: #002060; text-transform: uppercase; font-weight: bold; font-family: Arial;">Rizal Technological University</span> <br>
	                            <span style="color: #181717; font-family: Arial;">City of Mandaluyong and Pasig <!-- insert data --> </span>
	                        </div>
	                    </div>  
	                </header>
	            </div>
	            <!-- //Grid position of FOOTER box -->

	            <!-- Grid set position of GREETINGS, AVAILABILITY STATUS, and FEEDBACK box -->
	            <header class="showcase-dashboard">
	            	<!-- Grid position of welcome greetings box -->
	                <div class="top-box top-box-greet">
	                    <header>
	                    	<!-- Right position for welcome greetings box -->
	                        <div class="greet-div">
	                            <div class="status">
	                            	<!-- Greetings Content -->
	                                <div class="greet-content">
	                                	<img src="../assets/img/greet.png"/>
	                                    <h3><span style="color: #002060; font-weight: bold;">Hello Admin</span> 
				                            <span style="color: #EAB800; text-transform: uppercase;"> <?php echo $config_admin_id; ?> <!-- Display data (First Name of Admin) --> </span>
				                            <span style="color: #002060;">!</span></h3>
				                            <p> Welcome to your dashboard! </p>
	                                    </h3> <br> <br>

	                                    <!--digital clock start-->
									    <div class="datetime">
									    	<div class="date">
							                </div>

							                <div class="dayname">
							                    <script src="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/js//view_app_script.js" . FILE_VERSION; ?>"></script>
							                </div>
							            </div>
									    <!--digital clock end--> 
									</div>
									<!-- //Greetings Content -->
	                            </div>
	                        </div> 
	                        <!-- //Right position for welcome greetings box -->  
	                    </header>
	                </div>
	                <!-- //Grid position of welcome greetings box -->
	                <br>

	                <!-- Appointment Feedback Section  -->
					<!-- Feedback Status -->
					<?php
				if($feedback_size > 0) {
					?>
					<br>
					<div class="feedback-set">
						<h5> APPOINTMENT FEEDBACK </h5>
                    	<section class="parent">
				<?php
					foreach((array)$feedback_view as $feedback) {
						?>
							<div class="feedback">
	                    		<section class="feedback-child">
						            <table>
									    <tbody>
									    	<tr>
									    		<th><p> <?php echo htmlspecialchars($feedback["fback_fname"]); ?> </p></th> <!-- Show Data (Display Full Name of User) -->
									    		<th class="flex-header" style="justify-content: center;">
										<?php 
											if($feedback["fback_is_stsfd"]) {
												?>
													<div class="like" id="like">
										    			<i class="bi bi-heart-fill"></i>
								                    	<span class="like_dislike">Satisfied</span> <!-- Show Result Data (Display Rating) -->
							                		</div>
												<?php
											} else {
												?>
													<div class="dislike" id="dislike">
										    			<i class="bi bi-heart-half"></i>
								                    	<span class="like_dislike">Unsatisfied</span> <!-- Show Result Data (Display Rating) -->
							                		</div>
												<?php
											}
										?>
							                	</th>
									    	</tr>
									    </tbody>
									</table>
									<table>
									    <tbody>
									    	<tr>
									    		<td class="flex-category"><?php echo htmlspecialchars(ucfirst($feedback["fback_cat"]))?></td> <!-- Show Data (Display User Category) -->
										    	<td class="flex-classification"><?php echo htmlspecialchars($feedback["office_name"]); ?> </td> <!-- Show Data (Display BRANCH - Office) -->
									    <?php 
											$date_r = new DateTime($feedback["fback_sys_time"]);
											$date = $date_r->format("M d, Y");		
											$time = $date_r->format("h:i A");		
										?>
												
												<td class="flex-date"><?php echo htmlspecialchars($date); ?> </td> <!-- Show Data (Display DATE when feedback submitted) -->
										    	<td class="flex-time"><?php echo htmlspecialchars($time); ?> </td> <!-- Show Data (Display TIME when feedback submitted) -->
									    	</tr>
									    </tbody>
									</table>
									<div class="feedback-line"><br>
				                        <h5 style="justify-content: center; align-content: center; color: #3B3838; font-family: Arial;"> 
										<?php echo htmlspecialchars($feedback["fback_msg"]); ?>  <!-- Show Data (Display feedback) -->
				                        </h5><br>
                      				</div>
					            </section>
							</div>
						<?php
					}
				?>
						</section>
					</div>
					<?php
				}
						
			?>
					<!-- //Feedback Status -->
				</header>
				<!-- //Grid set position of GREETINGS, AVAILABILITY STATUS, and FEEDBACK box -->
			</section>
			<!-- //Appointment Container -->
		</div>
		<!-- //Contents Container -->
	</main>
	<!-- //Content Ends -->

	<!-- Javascript -->
	<script src="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/js/DashboardScript.js" . FILE_VERSION; ?>"></script>
	<script src="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/js/fnon.min.js"></script>
	<?php 
		if($isAlert) {
			echo "<script> Fnon.Alert.Danger({
				message: '". $message ."',
				title: '" . $title . "',
				btnOkText: 'Okay',
				fontFamily: 'Poppins, sans-serif'
			}); </script>";
		} else {
			if($is_under_maintenance) {
				echo "<script> Fnon.Alert.Dark({
					message: 'The system is still under maintenance, all users except system administrators are still prohibited to use the system.',
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