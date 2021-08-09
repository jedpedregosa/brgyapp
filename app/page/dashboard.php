<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Schedule.php");

    $first_name = getFirstName($admin_id);
    $office_name = getOfficeName($assigned_office);
	$campus_name = getCampusName($assigned_office);
    $total_app_today = totalAppointmentToday($assigned_office);
    $total_app_week = totalAppointmentOfWeek($assigned_office);
    $total_app_month = totalAppointmentOfMonth($assigned_office);

    $available_date = getNearAvailableDate();
	$max_available_date = getMaxAvailableDate();

	$closed_slots_toShow = getClosedSchedules($assigned_office);

	$date_to_check_r = new DateTime();
	$date_to_check = $date_to_check_r->format("Y-m-d");
	$availablity_status = !checkDaySched($date_to_check, $assigned_office);

	$availablity_status = ($availablity_status ? 'OPEN' : 'CLOSED');

	$feedback_view = getTwoFeedBack($assigned_office);
	$feedback_size = sizeof($feedback_view);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Dashboard</title>

	<link rel="stylesheet" href="../assets/css/OA-DashboardStyle.css">
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="../../assets/css/fnon.min.css" />
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

</head>
<body onload="initClock()">
	<div id = "pickcontainer"></div>
	<!-- Side Navigation Bar -->
	<div class="sidebar">

		<!-- User Image Container -->
		<div class="user-con">

			<!-- User Image Container -->
			<div class="user-img">
				<!-- User Image -->
				<div class="bar-user-img">
					<img src="view/load_image" id="bar-pic" alt="Not Found" onerror="this.src='../assets/img/user-icon.png'">
				</div>
				<!-- //User Image -->
			</div>
			<!-- //User Image Container -->

			<!-- User Name, Title and Line -->
			<div class="name"><?php echo htmlspecialchars($full_name); ?></div>
			<div class="job">Office Administrator</div>
			<div class="line"></div>
			<!-- //User Name, Title and Line -->

		</div>
		<!-- //User Image Container -->

		<!-- Navigation List -->
		<ul class="nav-list">
			<li>
				<i class="bi bi-search"></i>
				<input type="text" placeholder="Search...">
				<span class="tooltip">Search</span>
			</li>
			<li>
				<a href="javascript:window.location.reload(true)" class="active">
					<i class="bi bi-columns-gap"></i>
					<span class="links_name">DASHBOARD</span>
				</a>
				<span class="tooltip">Dashboard</span>
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
				<a href="profile">
					<i class="bx bx-user"></i>
					<span class="links_name">PROFILE</span>
				</a>
				<span class="tooltip">Profile</span>
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
							<img src="view/load_image" id="header-pic" alt="Not Found" onerror="this.src='../assets/img/user-icon.png'">
						</div>
						<!-- //User Image -->
					</div>
					<!-- //User Image Container -->

					<div class="user-name">
						<a href="profile"><h5><?php echo htmlspecialchars($full_name); ?></h5></a>
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
							<div><h4 class="total"> <?php echo htmlspecialchars($total_app_today); ?> </h4></div> <!-- Display Data (Show total number of appointment today)-->
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
							<div><h4 class="total"> <?php echo htmlspecialchars($total_app_week); ?> </h4></div> <!-- Display Data (Show total number of appointment this week)-->
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
							<div><h4 class="total"> <?php echo htmlspecialchars($total_app_month); ?></h4></div> <!-- Display Data (Show total number of appointment this month)-->
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
	                                    <h3><span style="color: #002060; font-weight: bold;">Hello</span> 
				                            <span style="color: #EAB800; text-transform: uppercase;"> <?php echo htmlspecialchars($first_name); ?><!-- Display data (First Name of Admin) --> </span>
				                            <span style="color: #002060;">,</span></h3>
				                            <p> Welcome to your dashboard! </p>
	                                    </h3> <br> <br>

	                                    <!--digital clock start-->
									    <div class="datetime">
									    	<div class="date">
										        <span id="month">Month</span>
										        <span id="daynum">00</span>,
										        <span id="year">Year</span>
										    </div>
										    <div class="day"><span id="dayname">Day</span></div>
										    
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

	                <!-- Grid position of AVAILABITY STATUS box -->
					<div class="unavailable-schedule">
	                	<!-- Font style uniform -->
	                    <div class="status-uniform">
	                    	<div class="set">
		                    	<section class="parent">
		                    		<section class="child">
				                        <span style="color: #002060; text-transform: uppercase;"> <?php echo htmlspecialchars($office_name); ?> <!-- insert data (Display Office Name) --> </span>
				                    </section>
			                        <section class="child">
				                        <span style="color: #002060;"> AVAILABILITY STATUS: </span>
				                        <span style="color: #EAB800; font-weight: bold;"> <?php echo htmlspecialchars($availablity_status); ?> </span> <!-- insert data (Display Office Current Availability Status) -->
				                    </section>
				                </section>
			                </div>
	                    </div>
	                    <div class="status-uniform child">
	                        <span style="color: #002060; text-transform: uppercase;"> <?php echo htmlspecialchars($campus_name); ?> </span>
	                    </div>

	                    <!-- Availability Status -->
	                    <div class="set">
	                    	<!-- Availability Status Container Position-->
	                    	<section class="parent">
	                    		<!-- Availability Status Content-->
	                    		<section class="child">
	                    			<!-- Availability Status Responsive Table-->
		                    		<table>
		                    			<caption>Unavailable Appointment Date/s</caption>
		                    		</table>
		                    		<div class="table-scroll">
		                    			<table>
		                    				<thead>
			                    				<tr>
			                    					<th scope="col" >Date</th> <!-- Date Table Header -->
			                    					<th scope="col">Time</th> <!-- Time Table Header-->
			                    				</tr>
										    </thead>

										    <!-- Display selected unavailable date/s -->
										    <!-- First Letter of Month for date column must be set to capital then lowercase the rest letters-->
										    <!-- Time indicator (AM/PM) must be uppercase-->
										    <tbody>
											<?php 
												if(!empty($closed_slots_toShow)) {
													foreach($closed_slots_toShow as $slots) {
														$date = new DateTime($slots[0]);
														$date_to_show = $date->format("F d, Y");
											?>
														<tr>
															<td scope="row" data-label="Date"><?php echo htmlspecialchars($date_to_show); ?></td> <!-- Display selected date (Date Picker) -->
															<td data-label="Time"><?php echo htmlspecialchars($slots[1] . ' - ' . $slots[2]); ?></td> <!-- Display selected time (Time Picker) -->
														</tr>
											<?php
													}
												}
											?>
										    </tbody>
										    <!-- //Display selected unavailable date/s -->
										</table>
									</div>
									<?php 
                                        if(empty($closed_slots_toShow)) {
                                            ?>
                                            	<center><em>No closed schedules yet.</em></center> <!-- Display if NO ITEMS in the TABLE -->
                                            <?php
                                        }
                                    ?>
									
									<!-- //Availability Status Responsive Table-->
								</section>

								<!-- Center vertical line divider -->
								<div class="border-line">
								</div>
								<!-- //Center vertical line divider -->

								<!-- Availability Status Content Selection-->
								<section class="child">
									<div class="availability-status">
										<table>
											<caption>Set Unavailable Date/s</caption>
											<form action = "../controllers/close-sched" method = "post" id = "form_close_sched">
												<caption><input type="date" id="calendar" id = "close_date" name = "close_date" min = "<?php echo $available_date; ?>" max = "<?php echo $max_available_date; ?>" required></caption> <!-- Insert Selected Date Unavailable Schedule -->
												<caption><input type = "time" id="time-from" name="time_from" value = "08:00" required> to <input type = "time" id="time-to" name="time_to" value = "08:00" required></caption> <!-- Insert Selected Time Unavailable Schedule -->
											<caption>
												<div class="date-picker">
													<button type = "reset">Reset</button> <!-- Reset Date and Time -->
													<button id="save" type="button">Save</button> <!-- Save Selected Unavailable Schedule -->
												</div>
									        </caption>
										</form>
										</table>
									</div>
								</section>
								<!-- //Availability Status Content Selection-->
							</section>
							<!-- //Availability Status Container Position-->
						</div>
						<!-- //Availability Status -->
					</div>
					<br>

					<!-- Appointment Feedback Section  -->
					<!-- Feedback Status -->
		<?php
				if($feedback_size > 0) {
					?>
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
	<script src="../assets/js/DashboardScript.js?version=2"></script>
	<script src="../../assets/js/fnon.min.js"></script>
	<?php 
		if($success) {
			echo "<script> Fnon.Alert.Warning({
				message: '". $message ."',
				title: '" . $title . "',
				btnOkText: 'Okay',
				btnOkColor: 'White',
            	btnOkBackground: '#002060',
				fontFamily: 'Poppins, sans-serif'
			}); </script>";
		} else if($task_error){
			echo "<script> Fnon.Alert.Danger({
				message: '". $message ."',
				title: '" . $title . "',
				btnOkText: 'Okay',
				fontFamily: 'Poppins, sans-serif'
			}); </script>";
		}
	?>
	<script type="text/javascript">
    function updateClock(){
      var now = new Date();
      var dname = now.getDay(),
          mo = now.getMonth(),
          dnum = now.getDate(),
          yr = now.getFullYear(),
          hou = now.getHours(),
          min = now.getMinutes(),
          sec = now.getSeconds(),
          pe = "AM";

          if(hou >= 12){
            pe = "PM";
          }
          if(hou == 0){
            hou = 12;
          }
          if(hou > 12){
            hou = hou - 12;
          }

          Number.prototype.pad = function(digits){
            for(var n = this.toString(); n.length < digits; n = 0 + n);
            return n;
          }

          var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
          var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
          var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
          var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
          for(var i = 0; i < ids.length; i++)
          document.getElementById(ids[i]).firstChild.nodeValue = values[i];
    }

    function initClock(){
      updateClock();
      window.setInterval("updateClock()", 1);
    }
    </script>
	<!-- //Javascript -->

</body>
</html>
