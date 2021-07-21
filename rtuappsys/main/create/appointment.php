<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		appointment.php (Web Page) -- 
 *  Description:
 * 		1. Provides an interface for the creation of appointments.
 * 		2. Load available schedules.
 * 
 * 	Date Created: 7th of July, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	Triggers for validation messages for the client side.
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 * **************************************************************************/

    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/module.php");

    // Session Side
    session_name("id");
    session_start();
    
    // Check if accessed from chck-appointment.php
    if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        header("Location: ../rtuappsys.php");
        die();
    }

    // Initialization of Session Values
    $fReqData = $_SESSION["userId"];
    $sReqData = $_SESSION["uLname"];
    $userType = $_SESSION["uType"];

    // Checking of identification information status
    if(doesUserHasApp($fReqData, $userType)) {
        // *********** Needs error message
        header("Location: ../main/rtuappsys.php");
        die();
    }

    // User type identifier
    $isStudent = false;
    $isEmp = false;
    $isGuest = false;

    // Check whether has an existing information from the database
    $userExists = doesUserExists($fReqData, $userType);
    $userData = null;  // Array of user data

    // Check user type
    if($userType == "student") {
        $isStudent = true;
    } else if($userType == "employee") {
        $isEmp = true;
    } else if($userType == "guest") {
        $isGuest = true;
    } else {
        header("Location: ../rtuappsys.php");
        die();
    }

    // Check whether has an existing information from the database
    if($userExists) {
        // Check if both user identification and lastname matches in the database
        if(doesUserMatch($fReqData, $sReqData, $userType)) {
            // Load the user's data
            $userData = getUserData($fReqData, $userType);
        } else {
            // if not, do not load (For Privacy)
            $userExists = false;
        }
    }

    // Server Date & Time
    date_default_timezone_set("Asia/Manila");
    $currentDateTime = new DateTime();
    $dateTime = $currentDateTime->format("F d, Y h:i:s");
?>

<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Make an Appointment</title>
    <link rel="stylesheet" href="../../assets/css/AppointmentStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        function getServerTime()  {
            return "<?php echo $dateTime; ?>";
        }
    </script>
</head>
<body>
    <div id="screen-overlay">
        <div class="screen-cv-spinner">
            <span class="screen-spinner"></span>
        </div>
    </div>
    <div class="container">
        <!-- HEADER -->
        <div class="apptlogo">
            <img src="../../assets/img/LOGO_appt.png">
        </div>

        <!-- STEP PROGRESS BAR -->
        <div class="progress-bar">
            <div class="step">
                <div class="bullet">
                    <span><img src="../../assets/img/app_info_icon_fullwhite.png" title="Location and Purpose"></span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <div class="bullet">
                    <span><img src="../../assets/img/date_time.png" title="Date and Time"></span>
                </div>
                <div class="check fas fa-check"></div>
            </div>

            <div class="step">
                <div class="bullet">
                    <span><img src="../../assets/img/confirm.png" title="Confirmation"></span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
        </div>

        <!-- LOCATION AND PURPOSE PAGE -->
        <div class="form-outer">
            <form action="#">
                <!-- ACTION FOR PHP -->
                <div class="page slide-page">
                    <!-- Put here your codes -->
                    <h4 style="position: relative; top: -5px; color: #3B3838; font-family: 'Poppins', sans-serif;">Fill out the fields to make an appointment</h4>
                        <hr style="position: relative; top: -10px;">
                        <div class="container-inputs">
                            <div class="container-office">
                                <select style="width: 150px;" id = "branch" onchange = "loadOffices()">
                                <option value="" disabled selected hidden>RTU Branch</option>
                                <option value="Boni Campus">Boni Campus</option>
                                <option value="Pasig Campus">Pasig Campus</option>
                            </select>
                            </div><br><br>
                            <div class="container-office">
                                <select name="Office" id="Office" class="Office" disabled>
                                <option value="" disabled selected hidden>Office</option>
                            </select>
                            </div>
                            <br><br>
                            <div class="container-purpose">
                                <br>
                                <textarea maxlength="150" placeholder="State your purpose here..." id = "purpose" required></textarea>
                                <label id="error-purpose"></label>
                            </div>
                            <div class="informationForm">
                                <div class="form-row">
                                    <?php 
                                        if($isStudent) {
                                            ?>
                                                <div class="form-group">
                                                    <input type="text" id="student-number" class="student-number" placeholder="Student Number" value = "<?php echo htmlspecialchars($fReqData); ?>" disabled required>
                                                </div>
                                            <?php
                                        } else if($isEmp){
                                            ?>
                                                <div class="form-group">
                                                    <input type="text" id="employee-number" class="student-number" placeholder="Employee Number" value = "<?php echo htmlspecialchars($fReqData); ?>" disabled required>
                                                </div>
                                            <?php 
                                        } else {
                                            ?>
                                                <div class="form-group">
                                                    <input type="text" id="email-address" class="email-address" placeholder="Email Address" value = "<?php echo htmlspecialchars($fReqData); ?>" disabled required>
                                                </div>
                                            <?php
                                        }
                                    ?>
                                    
                                    <div class="form-group">
                                        <input type="text" id="first-name" class="first-name" placeholder="First Name" 
                                        value = "<?php echo htmlspecialchars($userExists ? $userData[0] : ""); ?>" >
                                        <label id = "error-firstname"></label>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" id="last-name" class="last-name" placeholder="Last Name" value = "<?php echo htmlspecialchars($sReqData)?>">
                                        <label id = "error-lastname"></label>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="form-group">
                                        <input type="text" id="contact-number" class="contact-number" placeholder="Contact Number" 
                                            value = "<?php echo htmlspecialchars($userExists ? $userData[1] : ""); ?>">
                                            <label id = "error-contact-number"></label>
                                    </div>

                                <?php
                                    if($isGuest) {
                                        ?>
                                            <div class="form-group">
                                                <input type="text" id="affiliated-company" class="affiliated-company" placeholder="Affiliated Company"
                                                    value = "<?php echo htmlspecialchars($userExists ? $userData[3] : ""); ?>">
                                                    <label id = "error-affiliated-company"></label>
                                            </div>
                                        <?php
                                    } else {
                                        ?>
                                            <div class="form-group">
                                                <input type="text" id="email-address" class="email-address" placeholder="Email Address"
                                                    value = "<?php echo htmlspecialchars($userExists ? $userData[2] : ""); ?>">
                                                    <label id = "error-email-address"></label>
                                            </div>
                                        <?php
                                    }

                                    if($isGuest) {
                                ?>

                                    <div class="form-group">
                                        <input type="text" id="government-ID" class="government-ID" placeholder="Government ID"
                                            value = "<?php echo htmlspecialchars($userExists ? $userData[4] : ""); ?>">
                                            <label id = "error-government-ID"></label>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>



                        <!-- LOCATION AND PURPOSE PAGE BUTTONS -->
                        <div class="PageNameAndButtons">
                            <div class="pageName2-border">
                                <!-- CSS Line 171-184 -->
                                <p class="pageName">Appointment Info</p>
                                <button class="firstNext button2" type="button" style="position: relative; left: 18px; top: -0.5px;">Next</button>
                                <div id="screen-overlay">
                                    <div class="screen-cv-spinner">
                                        <span class="screen-spinner"></span>
                                    </div>
                                </div>
                                <!-- CSS Line 94-117 -->
                            </div>
                        </div>
                </div>

                <!-- DATE AND TIME PAGE -->
                <div class="page">
                    <!-- important -->
                    <!-- Put here your codes -->
                    <h4 style="top: -5px; color: #3B3838; font-family: 'Poppins', sans-serif;">Select date and time</h4>
                    <div class="calendar">
                        <div class="weekdays">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                        </div>
                        <div class="month">
                            <div class="controls">
                                <span class="prev_btn">&and;</span>
                                <span class="next_btn">&or;</span>
                            </div>
                            <div class="date">
                                <span class="month_ttl"></span>
                                <span class="year_ttl"></span>
                                <span class="day_num"></span>
                                <span class="day_ttl">Day</span>
                            </div>
                        </div>

                        <div class="days">
                            <div class="prev-date"></div>
                            <div></div>
                            <div class="next-date"></div>
                        </div>
                        <div style="display: none;">
                            <input type = "text" id = "slctdDate"/>
                        </div>
                        <div class="time" id = "slots">
                                <div>
                                    <input type="button" id = "TMSLOT-01" name="btn1" value="08:00 AM" onclick = "load_timeslot(this.id)" disabled/>
                                    <input type="button" id = "TMSLOT-02" name="btn2" value="08:30 AM" onclick = "load_timeslot(this.id)" disabled/>
                                    <input type="button" id = "TMSLOT-03" name="btn3" value="09:00 AM" onclick = "load_timeslot(this.id)" disabled/>
                                </div>
                                <div>
                                    <input type="button" id = "TMSLOT-04" name="btn4" value="09:30 AM" onclick = "load_timeslot(this.id)" disabled/>
                                    <input type="button" id = "TMSLOT-05" name="btn5" value="10:00 AM" onclick = "load_timeslot(this.id)" disabled/>
                                    <input type="button" id = "TMSLOT-06" name="btn6" value="10:30 AM" onclick = "load_timeslot(this.id)" disabled/>
                                </div>
                                <div>
                                    <input type="button" id = "TMSLOT-07" name="btn7" value="11:00 AM" onclick = "load_timeslot(this.id)" disabled/>
                                    <input type="button" id = "TMSLOT-08" name="btn8" value="11:30 AM" onclick = "load_timeslot(this.id)" disabled/>
                                    <input type="button" id = "TMSLOT-09" name="btn9" value="12:00 PM" onclick = "load_timeslot(this.id)" disabled/>
                                </div>
                                <div>
                                    <input type="button" id = "TMSLOT-10" name="btn10" value="12:30 PM" onclick = "load_timeslot(this.id)" disabled/>
                                    <input type="button" id = "TMSLOT-11" name="btn11" value="01:00 PM" onclick = "load_timeslot(this.id)" disabled/>
                                    <input type="button" id = "TMSLOT-12" name="btn12" value="01:30 PM" onclick = "load_timeslot(this.id)" disabled/>
                                </div>
                                <div>
                                    <input type="button" id = "TMSLOT-13" name="btn13" value="02:00 PM" onclick = "load_timeslot(this.id)" disabled/>
                                    <input type="button" id = "TMSLOT-14" name="btn14" value="02:30 PM" onclick = "load_timeslot(this.id)" disabled/> 
                                    <input type="button" id = "TMSLOT-15" name="btn15" value="03:00 PM" onclick = "load_timeslot(this.id)" disabled/> 
                                </div>
                        </div> 
                        <div class ="time" id = "slotsload">
                            <div id="timeslot-load" class = "overlay">
                                <div id ="timeslot-cv-spinner">
                                    <span id ="timeslot-spinner"></span>
                                    <span style = "display: block; margin-left: 5%; font-family: 'Poppins', sans-serif; color: #808080"> 
                                        Please wait..
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="../../assets/js/cal_script.js"></script>

                    <!-- DATE AND TIME PAGE BUTTONS -->
                    <div class="PageNameAndButtons">
                        <button class="prev-1 button1">Back</button>

                        <div class="pageName-border">
                            <p class="pageName">Date & Time</p>
                        </div>

                        <button class="next-1 button1" type="button">Next</button>
                    </div>
                </div>

                <!-- PERSONAL INFORMATION PAGE -->
                <!-- CONFIRMATION PAGE -->
                <div class="page">
                    
                    <h4 style="position: relative; top: -5px; color: #3B3838; font-family: 'Poppins', sans-serif;">Appointment Summary</h4>
                    <hr></hr>
                    <ul>

                        <!-- Put here the inputted personal information -->
                        <li class="li1"><strong>PERSONAL INFORMATION</strong></li>
                    <table class="table table1">
                        <tr>
                            <td class="td0">
                            <?php 
                                if($isStudent) {
                                    ?>
                                        <strong>Student Number</strong>
                                    <?php
                                } else if($isEmp) {
                                    ?>
                                        <strong>Employee Number</strong>
                                    <?php
                                } else {
                                    ?>
                                        <strong>Email Address</strong>
                                    <?php
                                }
                            ?>
                            </td>
                            <td class="td01">
                                <span id = "visitor-identification"><?php echo htmlspecialchars($fReqData); ?></span><br>
                            </td>
                            <td class="td02">
                                <strong>Contact Number</strong>
                            </td>
                            <td class="td03">
                                <span id = "visitor-contact"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Full Name</strong>
                            </td>
                            <td>
                                <span id = "visitor-fname"></span><br>
                            </td>
                            <td>
                            <?php 
                                if($isGuest) {
                                    ?>
                                        <strong>Affiliated Company</strong>
                                    <?php
                                } else {
                                    ?>
                                        <strong>Email Address</strong>
                                    <?php
                                }
                            ?>
                            </td>
                            <td>
                                <span id = "visitor-email-com"></span><br>
                            </td>
                        </tr>
                    </table>

                        <!-- Put here the inputted appointment information -->
                        <li class="li2"><strong>APPOINTMENT INFORMATION</strong></li>
                        <table class="table table2">
                            <tr>
                                <td class = "td1">
                                    <table>
                                        <tr>
                                            <td>
                                                <strong>RTU Branch</strong>
                                            </td>
                                            <td>
                                                <span id = "visitor-branch"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Office Name</strong>
                                            </td>
                                            <td>
                                                <span id = "visitor-office"></span>
                                            </td>
                                        </tr>
                                        <?php if($isGuest) { ?>
                                            <tr>
                                                <td>
                                                    <strong>Government ID</strong>
                                                </td>
                                                <td>
                                                    <span id = "visitor-govId"></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                                <td class = "td2">
                                    <table>
                                        <tr>
                                            <td>
                                                <strong>Date</strong>
                                            </td>
                                            <td>
                                                <span id = "sched-date"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Time</strong>
                                            </td>
                                            <td>
                                                <span id = "sched-time"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Purpose</strong>
                                            </td>
                                            <td>
                                                <span id = "sched-purpose"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        
                        <!-- Confrimation Button
                   <p class="rectangle">
                      &nbsp;&nbsp;&nbsp;CONFIRMATION &nbsp;&nbsp;&nbsp;<button class = "button1"><b>CONFIRM APPOINTMENT</b></button>
                   </p>
                   -->

                    </ul>
                    <!-- CONFIRMATION PAGE BUTTONS -->
                    <div class="PageNameAndButtons">
                        <button class="prev-2 button1">Back</button>

                        <div class="pageName-border">
                            <p class="pageName">Confirmation</p>
                        </div>

                        <button class="submit button1" type="button">Confirm</button>
                    </div>
                </div>


            </form>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <img src="../../assets/img/footer.png">
    </div>

    <!-- JAVASCRIPTS USED -->
    <script src="../../assets/js/AppointmentScript.js"></script>
    <script>
        
        // Input Fields
        const purpose = document.getElementById('purpose');
        const first_name = document.getElementById('first-name');
        const last_name = document.getElementById('last-name');
        const contact_number = document.getElementById('contact-number');
        const affiliated_company = document.getElementById('affiliated-company');
        const email_address = document.getElementById('email-address');
        const governmentID = document.getElementById('government-ID');

        // Error Labels
        const error_purpose = document.getElementById('error-purpose');
        const error_first_name = document.getElementById('error-first-name');
        const error_last_name = document.getElementById('error-last-name');
        const error_contact_number = document.getElementById('error-contact-number');
        const error_affiliated_company = document.getElementById('error-affiliated-company');
        const error_email_address = document.getElementById('error-email-address');
        const error_governmentID = document.getElementById('error-government-ID');

        var wordRegex = /^[a-zA-Z]*$/;
        var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var numberRegex = /^[0-9]*$/;


        purpose.addEventListener("keyup", function(event){
            if(purpose.value == null || purpose.value == ''){
                error_purpose.textContent = "Please fill up this field";
            } else {
                error_purpose.textContent = "";
            }
        });

        first_name.addEventListener("keyup", function(event){
            if(first_name.value == null || first_name.value == ''){
                error_first_name.textContent = "Please fill up this field";
            } else if (!first_name.value.match(wordRegex) || first_name.value.length < 2){
                error_first_name.textContent = "Invalid First Name";
            } else{
                error_first_name.textContent="";
            }
        });

        last_name.addEventListener("keyup", function(event){
            if(last_name.value == null || last_name.value == ''){
                error_last_name.textContent = "Please fill up this field";
            } else if (!last_name.value.match(wordRegex) || last_name.value.length < 2){
                error_last_name.textContent = "Invalid Last Name";
            } else{
                error_last_name.textContent="";
            }
        });

        contact_number.addEventListener("keyup", function(event){
            if(contact_number.value == null || contact_number.value == ''){
                error_contact_number.textContent = "Please fill up this field";
            } else if (!contact_number.value.match(numberRegex) || contact_number.value.length != 11){
                error_contact_number.textContent = "Invalid Contact Number";
            } else{
                error_contact_number.textContent="";
            }
        });

        affiliated_company.addEventListener("keyup", function(event){
            if(affiliated_company.value == null || affiliated_company.value == ''){
                error_affiliated_company.textContent = "Please fill up this field";
            } else if (!affiliated_company.value.match(wordRegex) || affiliated_company.value.length < 2){
                error_affiliated_company.textContent = "Invalid Company Name";
            } else{
                error_affiliated_company.textContent="";
            }
        });

        email_address.addEventListener("keyup", function(event){
            if(email_address.value == null || affiliemail_addressated_company.value == ''){
                error_email_address.textContent = "Please fill up this field";
            } else if (!email_address.value.match(emailRegex) || email_address.value.length < 2){
                error_email_address.textContent = "Invalid Email Address";
            } else{
                error_email_address.textContent="";
            }
        });

        governmentID.addEventListener("keyup", function(event){
            if(governmentID.value == null || governmentID.value == ''){
                error_governmentID.textContent = "Please fill up this field";
            } else if (!governmentID.value.match(wordRegex) || governmentID.value.length < 2){
                error_governmentID.textContent = "Invalid Governement ID";
            } else{
                error_governmentID.textContent="";
            }
        });

    </script>
</body>

</html>
