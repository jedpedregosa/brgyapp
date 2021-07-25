<?php
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		rtuappsys.php (Web Page) -- 
 *  Description:
 * 		1. Provides an interface for the user to intialize an appointment.
 * 
 * 	Date Created: 7th of July, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	Double html tags
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 ******************************************************************************/

	// Session for internal errors
	session_name("err");
	session_start();

	$alert = false;

	if(isset($_SESSION["error_status"])) {
		$error_code = $_SESSION["error_status"];
		$alert = true;

		if($error_code == 200) { // Information has an appointment booked.
			$message = "This information has an appointment already, please try again using other email if you think this is an error.";
		}
		unset($_SESSION["error_status"]);
	}
?>

<html>
  <head>
		<!-- Required meta tags -->
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<link rel="stylesheet" href="../assets/css/loginstyle.css?version=3">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="../assets/css/fnon.min.css" />

    	<title>RTU Online Appointment System</title>
  </head>
  <body>
		<!-- HEADER -->
  		<div class="headerBG">
  			<img src="../assets/img/header2.png">
  		</div>
		<div class="logoheader">
    		<img src="../assets/img/rtu_logo.png">
  		</div>

  		<!-- CONTENTS -->
		<div class="main">
			<!-- ROW -->
			<div class="row">
				<!-- COLUMN 1 -->
				<div class="col-1">
					<!-- RTU APPOINTMENT SYSTEM -->
					<div class="p1">
						<p>RTU APPOINTMENT <br> SYSTEM</p><!-- PUT USER'S NAME INSIDE THE SPAN TAG -->
					</div>
					<!-- //RTU APPOINTMENT SYSTEM -->
					<!-- WLCOME -->
					<div class="p2">
						<p>Welcome to Rizal Technological University!</p>
					</div>
					<!-- //WELCOME -->
					<!-- NOTE -->
					<div class="p3">
						<p>*For New Student and Alumni, please select Guest</p>
					</div>
					<!-- //NOTE -->
					<!-- MAKE AN APPOINTMENT -->
					<div class="dropdown">
						<button class ="dropbtn">Make an Appointment</button>
						<div id ="myDropdown"class="dropdown-content">
							<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">As a Student</button>
							<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">As an Employee</button>
							<button onclick="document.getElementById('id03').style.display='block'" style="width:auto;">As a Guest</button>
						</div>
					</div>
					<div id="id01" class="modal">
						<form class="modal-content animate" action="../includes/chk-appointment.php?type=student" method="post">
							<div class="imgcontainer">
								<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
								<img src="../assets/img/user.png" alt="Avatar" class="avatar">
							</div>

							<p class="p4"> Hello, Student. </p>
							<p class="p5">Make an appointment today at RTU!</p>

							<div class = "p7-div">
								<div class="info-msg">
									<i class="fa fa-info-circle"></i>
									Please be reminded that you can only use this information for at least one appointment at a time.
								</div>
							</div>
							

							<div class="container">
								<div class="container-inputs">
									<form>
										<div class="inputs">	
											<input type="text" placeholder="Student Number" name="studentNum" required id="studentNum">
											<input type="text" placeholder="Last Name" name="sLname" required id="sLname">
											<input type = "submit" class="button1" value = "Proceed" id="submit-student">
										</div>
									</form>
								</div>
							</div>
						</form>
					</div>
					<div id="id02" class="modal">
						<form class="modal-content animate" action="../includes/chk-appointment.php?type=employee" method="post">
							<div class="imgcontainer">
								<span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
								<img src="../assets/img/user.png" alt="Avatar" class="avatar">
							</div>

							<p class="p4"> Hello, Employee. </p>
							<p class="p5">Make an appointment today at RTU!</p>
							<div class = "p7-div">
								<div class="info-msg">
									<i class="fa fa-info-circle"></i>
									Please be reminded that you can only use this information for at least one appointment at a time.
								</div>
							</div>

							<div class="container">
								<div class="container-inputs">
									<form>
										<div class="inputs">
										<input type="text" placeholder="Employee Number" name="empNum" required id="empNum">
										<input type="text" placeholder="Last Name" name="eLname" required id="eLname">
										<input type = "submit" class="button1" value = "Proceed" id="submit-employee">
										</div>
									</form>
								</div>
							</div>
						</form>
					</div>
					<div id="id03" class="modal">
						<form class="modal-content animate" action="../includes/chk-appointment.php?type=guest" method="post">
							<div class="imgcontainer">
								<span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
								<img src="../assets/img/user.png" alt="Avatar" class="avatar">
							</div>
							
							<p class="p4"> Hello and welcome. </p>
							<p class="p5">Make an appointment today at RTU!</p>
							<div class = "p7-div">
								<div class="info-msg">
									<i class="fa fa-info-circle"></i>
									Please be reminded that you can only use this information for at least one appointment at a time.
								</div>
							</div>

							<div class="container">
								<div class="container-inputs">
									<form>
										<div class="inputs">
											<input type="text" placeholder="Email" name="email" required id="email">
											<input type="text" placeholder="Last Name" name="gLname" required id="gLname">
											<input type = "submit" class="button1" value = "Proceed" id="submit-guest">
										</div>
									</form>
								</div>
							</div>
						</form>
					</div>
					<!-- //MAKE AN APPOINTMENT -->

					<!-- VIEW AAPPOINTMENT -->
					<div class="dropbtn1">
						<div class ="button2" onclick="document.getElementById('id04').style.display='block'" style="width:auto;">
							View Appointment
						</div>
						<div id="id04" class="modal">
							<form class="modal-content animate" action="/action_page.php" method="post">
								<div class="imgcontainer">
									<span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
									<img src="../assets/img/user.png" alt="Avatar" class="avatar">
								</div>

								<p class="p5">VIEW MY APPOINTMENT</p>

								<div class="container">
									<div class="container-inputs">
										<form>
											<div class="inputs">
												<input type="text" id="email1" placeholder="Email Address" required="">
												<input type="text" id="lastname3" placeholder="Last Name" required="">

												<input class="button1" type="submit" value="Proceed">
											</div>   
										</form>              
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- //VIEW APPOINTMENT -->
					<!-- SUBMIT FEEDBACK -->
					<div>
						<a href="#" ><p class="p8">Submit Feedback here!</p></a>
					</div>
					<!-- //SUBMIT FEEDBACK -->
					
				</div>
				<!-- //COLUMN 1 -->

				<!-- DESIGN -->
				<div class="design">
					<img src="../assets/img/design.png">
				</div>
				<!-- //DESIGN -->
				
				<!-- COLUMN 2 -->
				<div class="col-2">
					<img src="../assets/img/frontgp.png" class="handBG">
					<div class="color-box"></div>
				</div>
				<!-- //COLUMN 2 -->

			</div>
			<!-- //ROW -->
		</div>
		<!-- //CONTENTS -->
		<!-- FOOTER -->
		<div class="footer">
			<div class="footer-bottom">
				COPYRIGHT &copy; 2021 RIZAL TECHNOLOGICAL UNIVERSITY<!-- COPYRIGHT -->
			</div>
		</div>
		<!-- //FOOTER -->


  			<script>
  				// Validation
  				// Unique ID's
  				const studentNum = document.getElementById('studentNum');
    			const empNum = document.getElementById('empNum');
    			const email = document.getElementById('email');

    			// User's Lastname
    			const sLname = document.getElementById('sLname');
    			const eLname = document.getElementById('eLname');
    			const gLname = document.getElementById('gLname');

    			// Submit
    			const submitStudent = document.getElementById('submit-student');
    			const submitEmployee = document.getElementById('submit-employee');
    			const submitGuest = document.getElementById('submit-guest');

    			// Regex for validation
    			var lastnameRegex = /^[a-zA-Z]*$/;
    			var studentRegex = /^[0-9]+-[0-9]*$/;
    			var employeeRegex = /^[A-Z]+-[0-9]+-[0-9]+-[0-9]+-[0-9]*$/;
    			var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
				submitStudent.addEventListener('click',()=>{
    			// Student Modal Validation
    			// Student Number Validation
    			if(studentNum.value == null || studentNum.value == ''){
    				studentNum.setCustomValidity('Please fill out this field');
    			}else if (!studentNum.value.match(studentRegex) || studentNum.value.length != 11){
    				studentNum.setCustomValidity('Invalid Student Number');
    			} else {
    				studentNum.setCustomValidity('');
    			}

    			// Student Last Name Validation
    			if(sLname.value == null || sLname.value == ''){
    				sLname.setCustomValidity('Please fill out this field');
    			}else if (!sLname.value.match(lastnameRegex) || sLname.value.length < 2){
    				sLname.setCustomValidity('Invalid Last Name');
    			} else {
    				sLname.setCustomValidity('');
    			}
    		});
				submitEmployee.addEventListener('click',()=>{
					// Employee Modal Validation
					// Employee Number Validation
					if(empNum.value == null || empNum.value == ''){
						empNum.setCustomValidity('Please fill out this field');
					}else if (!empNum.value.match(employeeRegex) || empNum.value.length != 11){
						empNum.setCustomValidity('Invalid Employee Number');
					} else {
						empNum.setCustomValidity('');
					}
					// Employee Last Name Validation
					if(eLname.value == null || eLname.value == ''){
						eLname.setCustomValidity('Please fill out this field');
					}else if (!eLname.value.match(lastnameRegex) || eLname.value.length < 2){
						eLname.setCustomValidity('Invalid Last Name');
					} else {
						eLname.setCustomValidity('');
					}
				});
				submitGuest.addEventListener('click',()=>{
					// Guest Modal Validation
					// Guest Number Validation
					if(email.value == null || email.value == ''){
						email.setCustomValidity('Please fill out this field');
					}else if (!email.value.match(emailRegex)){
						email.setCustomValidity('Invalid Email Address');
					} else {
						email.setCustomValidity('');
					}
					// Guest Last Name Validation
					if(gLname.value == null || gLname.value == ''){
						gLname.setCustomValidity('Please fill out this field');
					}else if (!gLname.value.match(lastnameRegex) || gLname.value.length < 2){
						gLname.setCustomValidity('Invalid Last Name');
					} else {
						gLname.setCustomValidity('');
					}
				});
			</script>
			<script src="../assets/js/fnon.min.js"></script>	
			<?php 
				if($alert) {
					echo "<script> Fnon.Alert.Warning('". $message ."','Unfortunately,','Okay'); </script>";
				}
			?>
	</body>
</html>
