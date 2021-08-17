<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		view-appointment.php (Web Page) -- 
 *  Description:
 * 		1. Previews appointment information to the visitor.
 * 		2. Reschedule Feature
 * 
 * 	Date Created: 14th of August, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	
 *  Lacks: An error catch if file stream fails (Front-end, JavaScript)
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 ******************************************************************************/

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Schedule.php");

    // Session Side
    session_name("cid");
    session_start();

    if(isset($_GET["islogout"])) {
        if($_GET["islogout"]) {
            unset($_SESSION["view_email"]);
            unset($_SESSION["view_lastname"]);
        }
    }

    $v_email;
    $v_lname;

    $v_user_type;
    $v_data = [];
    $v_app_data = [];
    $scheduled_date;
    $app_key;
    $file_keys;
    
    $isStudent = false;
    $isEmp = false;
    $isGuest = false;

    // Check if accessed from chck-appointment.php
    if(!(isset($_SESSION["view_email"]) && isset($_SESSION["view_lastname"]))) {
        if(isset($_POST["view_email"]) && isset($_POST["view_lname"])) {
            $_SESSION["view_email"] = $_POST["view_email"];
            $_SESSION["view_lastname"] = $_POST["view_lname"];
    
            header("Location: view-appointment");
        } else {
            header("Location: rtuappsys");
            die();
        }
    } else {
        $v_email = $_SESSION["view_email"];
        $v_lname = $_SESSION["view_lastname"];

        if(doesEmailHasAppData($v_email)) {
            $v_user_type = getUserTypeByEmail($v_email);
            $v_data = getUserDataByEmailLastN($v_email, $v_lname, $v_user_type);

            if($v_data) {
                //Is appointment not done
                $v_app_data = getAppointmentDetailsByEmail($v_email);
				checkAppointmentValidity($v_app_data[0]);

				if(doesEmailHasAppData($v_email)) {
					$file_keys = getFileKeysByAppId($v_app_data[0]);
					$sched_data = getScheduleDetailsByAppointmentId($v_app_data[0]);
					$office_slot = getValues($v_app_data[2], $sched_data[2]);
						
					$schedDate = new DateTime($sched_data[4]);
					$scheduled_date = $schedDate->format("F d, Y");

					$app_key = getAppointmentKeyByAppointmentId($v_app_data[0]);
				} else {
					goBack();
				}
            } else {
                goBack();
            }
        } else {
            goBack();
        }
    }

    if($v_user_type == "student") {
        $isStudent = true;
    } else if($v_user_type == "employee") {
        $isEmp = true;
    } else {
        $isGuest = true;
    } 

    function goBack() {

        $_SESSION["error_status"] = 201;
        unset($_SESSION["view_email"]);
        unset($_SESSION["view_lastname"]);

        header("Location: rtuappsys");
        die();
    }

    $file_dir = APP_FILES . $app_key . "/";
    if(isset($_GET["dl"])) {
		$original_filename = $file_dir . $file_keys[1] . '.pdf';
		$new_filename = 'RTUAppointment-'. $v_app_data[0] .'.pdf';

		// headers to send your file
		header("Content-Type: application/pdf");
		header("Content-Disposition: attachment; filename=" . $new_filename );

		ob_clean();
		flush();

		// upload the file to the user and quit
		readfile($original_filename);
		exit;
	}

	$isAppClosed = isSchedClosed($v_app_data[1]);
	$isReschedAllowed = isReschedAllowed($v_app_data[0]) || $isAppClosed;
	$avail_dates = loadAvailableDates($v_app_data[2]);
	$_SESSION["view_office"] = $v_app_data[2];

	$isAlert = false;
	$isSuccess = false;
	$title;
	$msg;

	if(isset($_SESSION["alrt_chngschd"])) {
		$isAlert = true;
		if($_SESSION["alrt_chngschd"] == 300) {
			$title = "Change of Schedule";
			$msg = "Your request to change schedule was successful, you may download your new appointment slip.";
			$isSuccess = true;
		} else if($_SESSION["alrt_chngschd"] == 301) {
			$title = "Schedule Unavailable";
			$msg = "Unfortunately, your requested schedule is not available. Please select another schedule.";
			$isSuccess = true;
		} else if($_SESSION["alrt_chngschd"] == 302) {
			$title = "Same Schedule";
			$msg = "You are rescheduling using the same time slot.";
			$isSuccess = true;
		} else {
			$title = "Server Error";
			$msg = "Oops, we might have been experiencing an error. Please try again later.";
		}
		unset($_SESSION["alrt_chngschd"]);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title> View Appointment - RTU Appointment System</title>

	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_PROTOCOL . HOST . "/assets/css/ViewAppointmentStyle.css" . FILE_VERSION ?>">
	<link rel="stylesheet" href="../assets/css/fnon.min.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<body onload="initClock()">
	
	<!-- Content Grid Wrapper -->
	<div class="wrapper">
		<!-- Appointment Header Container -->
		<section class="appointment-container"> 
        	<!-- Grid Position of Logo Box -->
            <div class="top-box">
            	<img src="../assets/img/rtu_logo.png"/>
            </div>
            <!-- //Grid position of logo box -->

            <!-- Grid for Header -->
	        <header class="showcase-header">

	        	<!-- Header Container -->
				<div class="header-box">
					<!-- Header Set box  -->
					<div class="header-set">
						<!-- Header flex Section -->
	                	<section class="parent">
	                		<div class="header">
	                			<!-- Header flex container -->
	                    		<section class="header-child">
						            <table>
									    <tbody>
									    	<tr>
									    		<th>  
									    			<span style="color: #EAB800;">Welcome,</span> 
								                    <span style="color: #002060;">
														<?php echo htmlspecialchars($v_data[0]);?> <!-- Show Data (Display Full Name of User) --> 
								                    </span>
								                    <span style="color: #EAB800;">!</span>
									    		</th> 
									    </tbody>
									</table>
								</section>
							</div>
							<div class="top-box-header total-box-today">
								<div class="datetime">
							    	<div class="date">
								        <span id="month">Month</span> &nbsp;
								        <span id="daynum">00</span>,
								        <span id="year">Year</span> 
								    </div>
							    </div>
							</div>
							<div class="top-box-header total-box-today">
								<div class="datetime">
								    <div class="day"><span id="dayname">Day</span></div>
							    </div>
							</div>
							<div class="top-box-header total-box-today">
								<div class="overviewcard-datetime">
									<div class="datetime">    	
									    <div class="time">
									    	<span id="hour">00</span>:
									        <span id="minutes">00</span>:
									        <span id="seconds">00</span>
									        <span id="period" style="margin-right: 2rem;">AM</span>   
									    </div>
								    </div>
								    <div>
								    	<a href="view-appointment?islogout=1" class="bi bi-box-arrow-right" title="Logout"></a> <!-- Link to logout-->
								    </div>
								</div>
							</div>
						</section>
					</div>
				</div>
				<!-- //Header Container -->
			</header>
			<!-- //Grid for Header -->
		</section>
		<!-- //Appointment Header Container -->		
	</div>
	<!-- //Content Grid Wrapper Ends -->

	<!-- Content Grid Wrapper -->
	<div class="wrapper">
		<!-- Appointment Information Container -->
		<section class="appointment-container"> 

            <!-- Grid for Content -->
	        <header class="showcase-content">
	        
	        	<!-- Appointment Information Section  -->
				<div class="content-box">
					<div class="header-set">
						<div class="overviewcard-appointment">
							<h3><span style="color:#EAB800;"> my</span><span style="color:#002060;"> Appointment </span></h3>
						</div>
						<!-- Appointment Information Responsive Flex  -->
	                	<section class="parent">
	                		<div class="information">
	                    		<section class="information-child">
						            <table>
									    <tbody>
									    	<tr>
									    		<caption><li class="li3" style=""><b>PERSONAL INFORMATION</b></caption>
									    	</tr>
									    </tbody>
									</table>
									<div class="content">
										<table>
										    <tbody>
										    	<tr>
										<?php
											if($isStudent) {
												?>
													<th class="flex-label">Student Number</th>
										    		<td class="flex-data"><?php echo htmlspecialchars($v_data[2]);?></td>
												<?php
											} else if($isEmp) {
												?>
													<th class="flex-label">Employee Number</th>
										    		<td class="flex-data"><?php echo htmlspecialchars($v_data[2]);?></td>
												<?php
											} else {
												?>
													<th class="flex-label">Email Address</th>
										    		<td class="flex-data"><?php echo htmlspecialchars($v_email);?></td>
												<?php
											}
										?>
												<!-- Show Data (Display Guest's Email Address -->
										    	</tr>
										    	<tr>
										    		<th class="flex-label">Full Name</th> 
										    		<td class="flex-data"><?php echo htmlspecialchars($v_lname . ", " . $v_data[0]);?></td> <!-- Show Data (Display Guest's Full Name) -->
										    	</tr>
										    	<tr>
										    		<th class="flex-label">Contact Number</th> 
										    		<td class="flex-data"><?php echo htmlspecialchars($v_data[1]);?></td> <!-- Show Data (Display Contact Number) -->
										    	</tr>
										    	<tr>
										<?php 
											if($isGuest) {
												?>
													<th class="flex-label">Affiliated Company</th>
										    		<td class="flex-data"><?php echo htmlspecialchars($v_data[2]);?></td>
												<?php
											} else {
												?>
													<th class="flex-label">Email Address</th>
										    		<td class="flex-data"><?php echo htmlspecialchars($v_email);?></td>
												<?php
											}
										?>
												<!-- Show Data (Display Company Name) -->
										    	</tr>
										    </tbody>
										</table>
									</div>
									<table>
									    <tbody>
									    	<tr>
									    		<caption> <li class="li4"><b>APPOINTMENT INFORMATION</b></li> </caption> 
							                	</th>
									    	</tr>
									    </tbody>
									</table>
									<div class="content">
									<table>
									    <tbody>
									    	<tr>
									    		<th class="flex-label">RTU Branch</th>
									    		<td class="flex-data"><?php echo htmlspecialchars($v_app_data[3]);?></td> <!-- Show Data (Display RTU Branch) -->
									    	</tr>
									    	<tr>
									    		<th class="flex-label">Office Name</th>
									    		<td class="flex-data"><?php echo htmlspecialchars($office_slot["officeValue"]);?></td> <!-- Show Data (Display Office Name) -->
									    	</tr>
									<?php 
										if($isGuest) {
										?>
											<tr>
									    		<th class="flex-label">Government ID</th> 
									    		<td class="flex-data"><?php echo htmlspecialchars($v_data[3]);?></td> <!-- Show Data (Display Government ID) -->
									    	</tr>
										<?php
										}
									?>
									    	<tr>
									    		<th class="flex-label">Date</th>
									    		<td class="flex-data"><?php echo htmlspecialchars($scheduled_date);?></td> <!-- Show Data (Display Appointment Date ) -->
									    	</tr>
									    	<tr>
									    		<th class="flex-label">Time</th> 
									    		<td class="flex-data"><?php echo htmlspecialchars($office_slot["timeValue"]);?></td> <!-- Show Data (Display Appointment Time) -->
									    	</tr>
									    	<tr>
									    		<th class="flex-label">Purpose</th>
									    		<td class="flex-data"><?php echo htmlspecialchars($v_app_data[4]);?></td> <!-- Show Data (Display Purpose) -->
									    	</tr>
									    </tbody>
									</table>
									</div>
					            </section>
							</div>
							<div class="top-box">
					<?php 
						if($isAppClosed) {
							?>
								<section class="appointment-closed">
									<?php 
										$r_date = new DateTime($v_app_data[5]);
										$date = $r_date->format("F d, Y h:i A");
									?>
		                    		<center>
		                    			<span> 
			                				Date & Time Generated : &ensp; 
			                				<b><?php echo htmlspecialchars($date);?></b><!-- Show Data (Display Date and Time Generated) -->
		                				</span>
		                			</center>
		                			<center>
		                				<p> 
			                				Status : &ensp; 
			                				<b style="color: #002060"> Closed </b> &ensp;<!-- Show Data (Display Availabilty Status if Pending, Cancelled, or Ongoing) -->
			                			</p>
			                			<br>
			                			<p>Sorry, it looks like the office in your appointment schedule is now unavailable. Please select a new schedule as early as you can to prevent appointment cancelation.</p>
			                		</center>
						            <table>
									    <tbody>
									    	<tr>
									    		<caption>
										    		<div class="overviewcard-qr"> 
											            <button class="bi bi-calendar-check reschedule" type="button" onclick="document.getElementById('id01').style.display='block'" title="Reschedule Appointment">
												            Reschedule <!-- Appointment Download Button  -->
												        </button>
												        
												    </div>
										    	</caption>
								    		</tr>
									    </tbody>
									</table>
								</section>
							<?php
						} else {
							?>
								<section class="appointment-qr">
									<?php 
										$r_date = new DateTime($v_app_data[5]);
										$date = $r_date->format("F d, Y h:i A");
									?>
		                    		<center>
		                    			<span> 
			                				Date & Time Generated : &ensp; 
			                				<b><?php echo htmlspecialchars($date);?></b><!-- Show Data (Display Date and Time Generated) -->
		                				</span>
		                			</center>
		                			<center>
		                				<p> 
			                				Status : &ensp; 
			                				<b style="color: #002060"> Ongoing </b> &ensp;<!-- Show Data (Display Availabilty Status if Pending, Cancelled, or Ongoing) -->
			                		<?php 
										if($isReschedAllowed) {
										?>			
											<button class="bi bi-calendar-check reschedule" type="button" onclick="document.getElementById('id01').style.display='block'" style="display: inline-flex;"> 
												&ensp;Reschedule <!-- Appointment Download Button  -->
											</button>
										<?php 
										}
									?>
			                			</p>
			                		</center>
						            <table>
									    <tbody>
									    	<tr>
									    		<caption>
										    		<div class="overviewcard-qr"> 
										    			<div class="qr">
												            <img src="load_qr"> <!-- Show Data (Display QR) -->
												            <p style="color: #767171; margin-bottom: 0.5rem;">
												            	<?php echo htmlspecialchars($file_keys[2]); ?><!-- Show Data (Display Code) -->
												        	</p> 
												            <a class="submit dlbutton" href = "view-appointment?dl=1"> 
													           Download Appointment Slip <!-- Appointment Download Button  -->
															</a>
												        </div>
												    </div>
										    	</caption>
								    		</tr>
									    </tbody>
									</table>
								</section>
							<?php
						}
					?>
								
							</div>
						</section>
					</div>
				</div>
				<!-- //Appointment Information Section -->
			</header>
			<!-- //Grid for Content -->
		</section>
		<!-- //Appointment Information Container -->		
	</div>
<?php 
	if($isReschedAllowed) { 
?>
	<div id="id01" class="modal">
		<form class="modal-content animate" action="../requests/resched" method="POST">
			<div class="imgcontainer">
				<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
			</div>
			<div class = "change-date-content">
				<p class="p5">Reschedule Appointment</p>
				<p class="p8"> Change your schedule from <strong><?php echo htmlspecialchars($scheduled_date . " " . $office_slot["timeValue"]);?></strong> to </p>
				<table class = "tb_modalgrid">
					<tr>
						<td>
							<div class="select-box">
								<div class="options-container">
						<?php 
							foreach((array)$avail_dates as $date) {
								$r_date = new DateTime($date);
								$f_date = $r_date->format("F d, Y");
								?>
									<div class="option">
										<input type="radio" class="radio" onclick = "dateSelect(this)" id="<?php echo htmlspecialchars($date);?>" name="slct_date" value = "<?php echo htmlspecialchars($date);?>">
										<label class = "lbl_date" for="<?php echo htmlspecialchars($date);?>"><?php echo htmlspecialchars($f_date);?></label>
									</div>
								<?php
								
							}
						?>			
								</div>
									<div class="selected">
										Select date..
									</div>
								</div>
							</div>
						</td>
						<td class = "modal-grid" style = "vertical-align: middle;">
							<div class ="time_none">
								<p class="p9">Please select a date first.<p>
							</div>
							<div class ="time_wait" style = "display: none">
								<p class="p9">Please Wait...<p>
							</div>
							<div class = "time_show" style = "display: none">
								<div class="select-box2">
									<div class="options-container2">
										<div class="option2" id="divTMSLOT-01">
											<input type="radio" class="radio" id="TMSLOT-01" name="time_slt" value="TMSLOT-01">
											<label class="lbl_time" for="TMSLOT-01">8:00 AM</label>
										</div>
										<div class="option2" id="divTMSLOT-02">
											<input type="radio" class="radio" id="TMSLOT-02" name="time_slt" value="TMSLOT-02">
											<label class="lbl_time" for="TMSLOT-02">8:30 AM</label>
										</div>
										<div class="option2" id="divTMSLOT-03">
											<input type="radio" class="radio" id="TMSLOT-03" name="time_slt" value="TMSLOT-03">
											<label class="lbl_time" for="TMSLOT-03">9:00 AM</label>
										</div>
										<div class="option2" id="divTMSLOT-04">
											<input type="radio" class="radio" id="TMSLOT-04" name="time_slt" value="TMSLOT-04">
											<label class="lbl_time" for="TMSLOT-04">9:30 AM</label>
										</div>
										<div class="option2" id="divTMSLOT-05">
											<input type="radio" class="radio" id="TMSLOT-05" name="time_slt" value="TMSLOT-05">
											<label class="lbl_time" for="TMSLOT-05">10:00 AM</label>
										</div>
										<div class="option2" id="divTMSLOT-06">
											<input type="radio" class="radio" id="TMSLOT-06" name="time_slt" value="TMSLOT-06">
											<label class="lbl_time" for="TMSLOT-06">10:30 AM</label>
										</div>
										<div class="option2" id="divTMSLOT-07">
											<input type="radio" class="radio" id="TMSLOT-07" name="time_slt" value="TMSLOT-07">
											<label class="lbl_time" for="TMSLOT-07">11:00 AM</label>
										</div>
										<div class="option2" id="divTMSLOT-08">
											<input type="radio" class="radio" id="TMSLOT-08" name="time_slt" value="TMSLOT-08">
											<label class="lbl_time" for="TMSLOT-08">11:30 AM</label>
										</div>
										<div class="option2" id="divTMSLOT-09">
											<input type="radio" class="radio" id="TMSLOT-09" name="time_slt" value="TMSLOT-09">
											<label class="lbl_time" for="TMSLOT-09">12:00 PM</label>
										</div>
										<div class="option2" id="divTMSLOT-10">
											<input type="radio" class="radio" id="TMSLOT-10" name="time_slt" value="TMSLOT-10">
											<label class="lbl_time" for="TMSLOT-10">12:30 PM</label>
										</div>
										<div class="option2" id="divTMSLOT-11">
											<input type="radio" class="radio" id="TMSLOT-11" name="time_slt" value="TMSLOT-11">
											<label class="lbl_time" for="TMSLOT-11">1:00 PM</label>
										</div>
										<div class="option2" id="divTMSLOT-12">
											<input type="radio" class="radio" id="TMSLOT-12" name="time_slt" value="TMSLOT-12">
											<label class="lbl_time" for="TMSLOT-12">1:30 PM</label>
										</div>
										<div class="option2" id="divTMSLOT-13">
											<input type="radio" class="radio" id="TMSLOT-13" name="time_slt" value="TMSLOT-13">
											<label class="lbl_time" for="TMSLOT-13">2:00 PM</label>
										</div>
										<div class="option2" id="divTMSLOT-14">
											<input type="radio" class="radio" id="TMSLOT-14" name="time_slt" value="TMSLOT-14">
											<label class="lbl_time" for="TMSLOT-14">2:30 PM</label>
										</div>
										<div class="option2" id="divTMSLOT-15">
											<input type="radio" class="radio" id="TMSLOT-15" name="time_slt" value="TMSLOT-15">
											<label class="lbl_time" for="TMSLOT-15">3:00 PM</label>
										</div>
									</div>
										<div class="selected2">
											Select timeslot..
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
				<div class = "button-group">
					<button class="cancel" type="button" onclick="document.getElementById('id01').style.display='none'" style="display: inline-flex;"> 
						&ensp;Cancel <!-- Appointment Download Button  -->
					</button>
					<input class="continue" type="submit" style="display: inline-flex;" name = "sbmt_rsched" value = "Continue"> 
						 <!-- Appointment Download Button  -->
					</input>
				</div>
			</div>
		</form>
	</div>
<?php 
	}
?>

	<!-- DESIGN -->
	<div class="a">
	    <img src="../assets/img/design.png" width="100" height="100"> 
	</div>
	<div class="b">
	    <img src="../assets/img/design.png" width="100" height="100"> 
	</div>

	<!-- FOOTER -->
	<div class="footer">
	    <p>COPYRIGHT © 2021 RIZAL TECHNOLOGICAL UNIVERSITY</p>
	</div>

	<!-- Javascript -->
	<script src = "../assets/js/view_app_script.js"></script>
	<script src="../assets/js/fnon.min.js"></script>	
	<?php 
		if($isAlert) {
			if($isSuccess) {
				echo "<script> Fnon.Alert.Warning({
					message: '". $msg ."',
					title: '" . $title . "',
					btnOkText: 'Okay',
					titleBackground: '#002060',
					titleColor: 'White',
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