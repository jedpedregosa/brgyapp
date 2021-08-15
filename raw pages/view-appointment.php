<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");

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

        if(doesEmailHasApp($v_email)) {
            $v_user_type = getUserTypeByEmail($v_email);
            $v_data = getUserDataByEmailLastN($v_email, $v_lname, $v_user_type);

            if($v_data) {
                //Is appointment not done
                if(!isAppointmentDoneByEmail($v_email)) {
                    $v_app_data = getAppointmentDetailsByEmail($v_email);
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

    $file_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/files/" . $app_key . "/";
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
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title> View Appointment </title>

	<link rel="stylesheet" href="ViewAppointmentStyle.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
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
								                    	Ezekiel Villanueva <!-- Show Data (Display Full Name of User) --> 
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
								    	<a href="#" class="bi bi-box-arrow-right" title="Logout"></a> <!-- Link to logout-->
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
							<h3><span style="color:#EAB800;"> my</span>&nbsp;<span style="color:#002060;"> Appointment </span></h3>
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
										    		<th class="flex-label">Student Number</th>
										    		<td class="flex-data">xxxx - xxxxxx</td> <!-- Show Data (Display Student Number -->
										    	</tr>
										    	<tr>
										    		<th class="flex-label">Full Name</th> 
										    		<td class="flex-data">Student Name</td> <!-- Show Data (Display Student's Full Name) -->
										    	</tr>
										    	<tr>
										    		<th class="flex-label">Contact Number</th> 
										    		<td class="flex-data">09183819739</td> <!-- Show Data (Display Contact Number) -->
										    	</tr>
										    	<tr>
										    		<th class="flex-label">Email Address</th>
										    		<td class="flex-data">sample@rtu.edu.ph</td> <!-- Show Data (Display email) -->
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
									    		<td class="flex-data">Boni</td> <!-- Show Data (Display RTU Branch) -->
									    	</tr>
									    	<tr>
									    		<th class="flex-label">Office Name</th>
									    		<td class="flex-data">Registrar</td> <!-- Show Data (Display Office Name) -->
									    	</tr>
									    	<tr>
									    		<th class="flex-label">Government ID</th> 
									    		<td class="flex-data">RTU ID</td> <!-- Show Data (Display Government ID) -->
									    	</tr>
									    	<tr>
									    		<th class="flex-label">Date</th>
									    		<td class="flex-data">August 09, 2021</td> <!-- Show Data (Display Appointment Date ) -->
									    	</tr>
									    	<tr>
									    		<th class="flex-label">Time</th> 
									    		<td class="flex-data">10:00 AM – 11:30 AM</td> <!-- Show Data (Display Appointment Time) -->
									    	</tr>
									    	<tr>
									    		<th class="flex-label">Purpose</th>
									    		<td class="flex-data">Appointment reason</td> <!-- Show Data (Display Purpose) -->
									    	</tr>
									    </tbody>
									</table>
									</div>
					            </section>
							</div>
							<div class="top-box">
	                    		<section class="appointment-qr">
		                    		<center>
		                    			<span> 
			                				Date & Time Generated : &ensp; 
			                				<b> Monday, 02 August 2021 05:46 pm </b><!-- Show Data (Display Date and Time Generated) -->
		                				</span>
		                			</center>
		                			<center>
		                				<p> 
			                				Status : &ensp; 
			                				<b style="color: #002060"> Pending </b> &ensp;<!-- Show Data (Display Availabilty Status if Pending, Cancelled, or Ongoing) -->
			                				<button class="reschedule" type="button" onclick="" id="myBtn" style="display: inline-flex;" title="Reschedule Appointment"> 
												Reschedule

												<!-- The Modal -->
												<div id="myModal" class="modal">

													<!-- Modal content -->
													<div class="modal-content">
														<strong><h3 class="mod1">Change your schedule</h3></strong>
														<br><br><br>
														<h3 class="mod2">Change Schedule</h3>
															<div class="top-box-header total-box-today">
																<div class="datetime">
																	<div class="date">
																		<span id="month">Month</span> &nbsp;
																		<span id="daynum">Date</span>,
																		<span id="year">Year</span> 
																	</div>
																</div>
															</div>
														<br>
														<div style="display: inline-flex;">
															<div class="custom-select" style="width:50%; margin-right: 5px;">
																<select>
																	<option value="0">Select available date</option>
																	<option value="1">Date 1</option>
   															 		<option value="2">Date 2</option>
    																<option value="3">Date 3</option>
    																<option value="4">Date 4</option>
    																<option value="5">Date 5</option>
    															</select>
    														</div>

    														<div class="custom-select" style="width:50%; margin-left: 5px;">
																<select>
																	<option value="0">Select available time</option>
																	<option value="1">Slot 1</option>
   															 		<option value="2">Slot 2</option>
    																<option value="3">Slot 3</option>
    																<option value="4">Slot 4</option>
    																<option value="5">Slot 5</option>
    															</select>
    														</div>
														</div>
														<br><br>
														<div style="display: inline-flex;">
															<input type="button" id="Cancel" class="modbutton modbutton1" value="Cancel">
															<input type="button" id="Done" class="modbutton modbutton2" value="Done" onclick="">
														</div>
														    <span class="close"></span>
														    <br><br>
														    <span>Click anywhere to close</span>

													</div>
												</div>
												<!-- Appointment Download Button  -->
											</button>
			                			</p>
			                		</center>
						            <table>
									    <tbody>
									    	<tr>
									    		<caption>
										    		<div class="overviewcard-qr"> 
										    			<div class="qr">
												            <img src="Images/QR.png"> <!-- Show Data (Display QR) -->
												            <p style="color: #767171; margin: .5rem 0;">
												            	Appointment No: <!-- Show Data (Display Code) -->
												        	</p> 
												            <button class="submit dlbutton" type="button" onclick=""> 
													            DOWNLOAD APPOINTMENT SLIP <!-- Appointment Download Button  -->
													        </button>
												        </div>
												    </div>
										    	</caption>
								    		</tr>
									    </tbody>
									</table>
								</section>
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
	<script type="text/javascript">
		// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
	</script>
<script type="text/javascript">
	var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
</script>

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

</body>
</html>