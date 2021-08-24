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

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/module.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    // Session Side
    session_name("cid");
    session_start();
    
    // Check if accessed from chck-appointment.php
    if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        header("Location: ../rtuappsys");
        die();
    }

    if(isset($_SESSION["app_session_expiry"])) {
        if($_SESSION["app_session_expiry"] < time()) {
            unset($_SESSION["app_session_expiry"]);
            header("Location: ../rtuappsys");
            die();
        }
    } else {
        header("Location: ../rtuappsys");
        die();
    }
    
    // Initialization of Session Values
    $fReqData = $_SESSION["userId"];
    $sReqData = $_SESSION["uLname"];
    $userType = $_SESSION["uType"];

    // Checking of identification information status
    if(doesUserHasApp($fReqData, $userType)) {
        // *********** Needs error message
        header("Location: ../rtuappsys");
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
        header("Location: ../rtuappsys");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make an Appointment</title>
    
    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_PROTOCOL . HOST . "/assets/css/AppointmentStyle.css" . FILE_VERSION; ?>">
    <link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/css/fnon.min.css" />

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
    <div class="main-container">
        <!-- HEADER -->
        <div class="logo-container">
            <img src="../../assets/img/LOGO_appt.png">
        </div>

        <!-- STEP PROGRESS BAR -->
        <div class="progress-bar-container">
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
        </div>


        <!-- LOCATION AND PURPOSE PAGE -->
        <div class="form-outer">
            <form action="#">
                <!-- ACTION FOR PHP -->
                <div class="page slide-page">
                    <!-- Put here your codes -->
                    <h4>Fill out the fields to make an appointment</h4>
                    <hr>

                    <div class="inputs-row1">
                        <div class="select-branch">
                            <select id = "branch" onchange = "loadOffices()">
                                    <option value="" disabled selected hidden>RTU Branch</option>
                                    <option value="Boni Campus">Boni Campus</option>
                                    <option value="Pasig Campus">Pasig Campus</option>
                                </select>

                        </div>

                        <div class="select-office">
                            <select name="Office" id="Office" class="Office" disabled>
                                    <option value="" disabled selected hidden>Office</option>
                                    <option value="">Curriculum and Instructional Resources Development Center</option>
                                </select>
                        </div>

                        <div class="purpose">
                            <textarea maxlength="150" placeholder="State your purpose here" id="purpose"></textarea>
                        </div>
                    </div>
                    
                    <div class="inputs-row2">
                                <?php 
                                    if($isStudent) {
                                        ?>
                                            <div class="primary">
                                                <input type="text" id="student-number" class="student-number" placeholder="Student Number" value = "<?php echo htmlspecialchars($fReqData); ?>" disabled required>
                                            </div>
                                        <?php
                                    } else if($isEmp){
                                        ?>
                                                <div class="primary">
                                                <input type="text" id="employee-number" class="employee-number" placeholder="Employee Number" value = "<?php echo htmlspecialchars($fReqData); ?>" disabled required>
                                            </div>
                                        <?php 
                                    } else {
                                        ?>
                                            <div class="primary">
                                                <input type="text" id="email-address" class="email-address" placeholder="Email Address" value = "<?php echo htmlspecialchars($fReqData); ?>" disabled required>
                                            </div>
                                        <?php
                                    }
                                ?>

                                <div class="first-name">
                                    <input type="text" id="first-name" class="first-name" minLength = "2" maxLength = "20" placeholder="First Name" 
                                    value = "<?php echo htmlspecialchars($userExists ? $userData[0] : ""); ?>" >
                                    <label id = "error-first-name"></label>
                                </div>

                                <div class="last-name">
                                    <input type="text" id="last-name" class="last-name" placeholder="Last Name" minLength = "2" maxLength = "20" value = "<?php echo htmlspecialchars($sReqData)?>">
                                    <label id = "error-last-name"></label>
                                </div>
                                <div class="contact-number">
                                    <input type="text" id="contact-number" class="contact-number" minLength = "2" maxlength = "20" placeholder="Contact Number" 
                                        value = "<?php echo htmlspecialchars($userExists ? $userData[1] : ""); ?>">
                                        <label id = "error-contact-number"></label>
                                </div>

                                <?php
                                if($isGuest) {
                                    ?>
                                        <div class="email-address">
                                            <input type="text" id="affiliated-company" class="affiliated-company" minLength = "2" maxlength = "12" placeholder="Type of ID (SSS, PHIL-Health)"
                                                value = "<?php echo htmlspecialchars($userExists ? $userData[3] : ""); ?>">
                                                <label id = "error-affiliated-company"></label>
                                        </div>
                                    <?php
                                } else {
                                    ?>
                                        <div class="email-address">
                                            <input type="text" id="email-address" class="email-address" minLength = "2" maxlength = "30" placeholder="Email Address"
                                                value = "<?php echo htmlspecialchars($userExists ? $userData[2] : ""); ?>">
                                                <label id = "error-email-address"></label>
                                        </div>
                                    <?php
                                }

                                if($isGuest) {
                            ?>

                                <div class="govID">
                                    <input type="text" id="government-ID" class="government-ID" maxlength = "30"  placeholder="Identification No."
                                        value = "<?php echo htmlspecialchars($userExists ? $userData[4] : ""); ?>">
                                        <label id = "error-government-ID"></label>
                                </div>
                                <?php } ?>
                    </div>

                    <div class="button-page-name">
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
                    </div>           
        

                <!-- DATE AND TIME PAGE -->
                <div class="page">
                    <!-- Put here your codes -->
                    <div class="row">
                        <!--Page-->
                        <div class="head">
                           <h4 style="top: -5px; color: #3B3838; font-family: 'Poppins', sans-serif;">Select date and time</h4>
                            <hr>
                        </div>

                        <div class="column2_row1">
                            <!-- RIGHT COL-->
                            <div class="month">
                                <div class="controls">
                                    <span class="prev_btn">&and;</span>
                                    <br>
                                    <span class="next_btn">&or;</span>
                                </div>
                                <div class="date">
                                    <span class="month_ttl"></span>
                                    <span class="year_ttl"></span>
                                    <span class="day_num"></span>
                                    <span class="day_ttl">Day</span>
                                </div>
                            </div>
                        </div>

                        <div class="column_row2">
                            <!--LEFT COL-->
                            <div class="weekdays">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                        </div>
                            <div class="days">
                                <div class="prev-date"></div>
                                <div></div>
                                <div class="next-date"></div>
                            </div>
                            <div style="display: none;">
                                <input type="text" id="slctdDate" />
                            </div>
                        </div>

                        <div class="column2_row3">
                            <div class="time" id="slots">
                                <!-- RIGHT COL -->
                                <div>
                                    <input type="button" id="TMSLOT-01" name="btn1" value="08:00 AM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-02" name="btn2" value="08:30 AM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-03" name="btn3" value="09:00 AM" onclick="load_timeslot(this.id)" disabled/>
                                </div>
                                <div>
                                    <input type="button" id="TMSLOT-04" name="btn4" value="09:30 AM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-05" name="btn5" value="10:00 AM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-06" name="btn6" value="10:30 AM" onclick="load_timeslot(this.id)" disabled/>
                                </div>
                                <div>
                                    <input type="button" id="TMSLOT-07" name="btn7" value="11:00 AM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-08" name="btn8" value="11:30 AM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-09" name="btn9" value="12:00 PM" onclick="load_timeslot(this.id)" disabled/>
                                </div>
                                <div>
                                    <input type="button" id="TMSLOT-10" name="btn10" value="12:30 PM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-11" name="btn11" value="01:00 PM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-12" name="btn12" value="01:30 PM" onclick="load_timeslot(this.id)" disabled/>
                                </div>
                                <div>
                                    <input type="button" id="TMSLOT-13" name="btn13" value="02:00 PM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-14" name="btn14" value="02:30 PM" onclick="load_timeslot(this.id)" disabled/>
                                    <input type="button" id="TMSLOT-15" name="btn15" value="03:00 PM" onclick="load_timeslot(this.id)" disabled/>
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
                        <!-- scripts -->
                    </div>

                    <!-- DATE AND TIME PAGE BUTTONS -->
                    <div class="PageNameAndButtons">
                        <button class="prev-1 button1">Back</button>

                        <div class="pageName-border">
                            <p class="pageName">Date & Time</p>
                        </div>

                        <button class="next-1 button1" type="button">Next</button>
                    </div>
                </div>


                            <!--Confimation Page -->
                            <div class="page">
                    <h4>Appointment Summary</h4>
                    <hr>

                    <div class="confirmation-content-container">

                        <div class="personal-info-container">
                            <div class="personal-info-text">
                                <li><b>PERSONAL INFORMATION</b></li>
                            </div>

                            <!--Visitor Identification-->
                            <?php 
                                if($isStudent) {
                                    ?>
                                        <strong class="primary-con">Student Number</strong>
                                    <?php
                                } else if($isEmp) {
                                    ?>
                                        <strong class="primary-con">Employee Number</strong>
                                    <?php
                                } else {
                                    ?>
                                        <strong class="primary-con">Email Address</strong>
                                    <?php
                                }
                            ?>
                            <span id = "visitor-identification"><?php echo htmlspecialchars($fReqData); ?></span>
                             <!--Visitor Identification-->

                            <!--Contact Number-->
                            <strong class="contact-number-con">Contact Number</strong>
                            <span id="visitor-contact"></span>
                            <!--Contact Number-->

                            <!--Full Name-->
                            <strong class="full-name-con">Full Name</strong>
                            <span id="visitor-fname"></span>
                            <!--Full Name-->


                            <!--Email Address-->
                            <?php 
                                if($isGuest) {
                                    ?>
                                        <strong class="email-con">Type of ID</strong>
                                    <?php
                                } else {
                                    ?>
                                        <strong class="email-con">Email Address</strong>
                                    <?php
                                }
                            ?>
                            <span id="visitor-email-com"></span>
                            <!--Email Address-->


                        </div>

                        <div class="appointment-info-container">

                            <div class="appointment-info-text">
                                <li><b>APPOINTMENT INFORMATION</b></li>
                            </div>

                            <strong class="rtu-branch-con">RTU Branch</strong>
                            <span id="visitor-branch"></span>

                            <strong class="office-name-con">Office Name</strong>
                            <span id="visitor-office"></span>

                            <strong class="date-con">Date</strong>
                            <span id="sched-date"></span>

                            <strong class="time-con">Time</strong>
                            <span id="sched-time"></span>

                            <strong class="purpose-con">Purpose</strong>
                            <span id="sched-purpose"></span>

                            <?php if($isGuest) { ?>
                                <tr>
                                    <td>
                                    <strong class="govID-con">Identification No.</strong>
                                    </td>
                                    <span id="visitor-govId"></span>
                                    </td>
                                </tr>
                                <?php } ?>


                        </div>

                        <div class="agreement-container">
                            <input type="checkbox" name="agreement" id="agreement">
                            <label for="agreement">I confirm that the above information is <b> true and correct</b>. 
                                And <b>I consent Rizal Technological University</b> under the standards of Data Protection and Privacy to <b>collect and process</b> the given data</label>
                        </div>

                    </div>

                    <div class="PageNameAndButtons">
                        <button class="prev-2 button1">Back</button>

                        <div class="pageName-border">
                            <p class="pageName">Confirmation</p>
                        </div>

                        <button class="submit button1 confirm" type="button">Confirm Appointment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer-container">
        <img src="../../assets/img/footer.png">
    </div>

    <!-- JAVASCRIPTS USED -->
    <script src="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/js/fnon.min.js"></script>
    <script src="<?php echo HTTP_PROTOCOL . HOST . "/assets/js/AppointmentValidation.js" . FILE_VERSION; ?>"></script>
    <script src="<?php echo HTTP_PROTOCOL . HOST . "/assets/js/Calendar.js" . FILE_VERSION; ?>"></script>
    <script src="<?php echo HTTP_PROTOCOL . HOST . "/assets/js/AppointmentScript.js" . FILE_VERSION; ?>"></script>
</body>

</html>
