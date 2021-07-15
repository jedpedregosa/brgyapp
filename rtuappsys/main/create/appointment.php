<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");

    session_name("id");
    session_start();
    
    if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        header("Location: ../rtuappsys.php");
        die();
    }
    // Initialization
    $fReqData = $_SESSION["userId"];
    $sReqData = $_SESSION["uLname"];
    $userType = $_SESSION["uType"];

    if(doesUserHasApp($fReqData, $userType)) {
        // *********** Needs error message
        header("Location: ../main/rtuappsys.php");
        die();
    }

    $isStudent = false;
    $isEmp = false;
    $isGuest = false;
    $userExists = doesUserExists($fReqData, $userType);
    $userData = null;

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

    if($userExists) {
        if(doesUserMatch($fReqData, $sReqData, $userType)) {
            $userData = getUserData($fReqData, $userType);
        } else {
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        function getServerTime()  {
            return "<?php echo $dateTime; ?>";
        }
    </script>
</head>

<body>
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
                    <h4 style="position: relative; top: -5px; color: #3B3838; font-family: Arial;">Fill out the fields to make an appointment</h3>
                        <hr style="position: relative; top: -10px;">
                        <div class="container-inputs">
                            <div class="container-office">
                                <select style="width: 150px;" id = "branch">
                                <option value="" disabled selected hidden>RTU Branch</option>
                                <option value="Boni Campus">Boni Campus</option>
                                <option value="Pasig Campus">Pasig Campus</option>
                            </select>
                            </div><br><br>
                            <div class="container-office">
                                <select name="Office" id="Office" class="Office">
                                <option value="" disabled selected hidden>Office</option>
                                <option value="RTU-O01">Curriculum and Instructional Resources Development Center</option>
                                <option value="RTU-O02">Alumni Relations and Placement Office</option>
                                <option value="RTU-O03">Disaster Risk Protection Office</option>
                                <option value="RTU-O04">University Data Protection Office</option>
                            </select>
                            </div>
                            <br><br>
                            <div class="container-purpose">
                                <br>
                                <textarea placeholder="State your purpose here..." id = "purpose" required></textarea>
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
                                    </div>

                                    <div class="form-group">
                                        <input type="text" id="last-name" class="last-name" placeholder="Last Name" value = "<?php echo htmlspecialchars($sReqData)?>">
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="form-group">
                                        <input type="text" id="contact-number" class="contact-number" placeholder="Contact Number" 
                                            value = "<?php echo htmlspecialchars($userExists ? $userData[1] : ""); ?>">
                                    </div>

                                <?php
                                    if($isGuest) {
                                        ?>
                                            <div class="form-group">
                                                <input type="text" id="affiliated-company" class="affiliated-company" placeholder="Affiliated Company"
                                                    value = "<?php echo htmlspecialchars($userExists ? $userData[3] : ""); ?>">
                                            </div>
                                        <?php
                                    } else {
                                        ?>
                                            <div class="form-group">
                                                <input type="text" id="email-address" class="email-address" placeholder="Email Address"
                                                    value = "<?php echo htmlspecialchars($userExists ? $userData[2] : ""); ?>">
                                            </div>
                                        <?php
                                    }

                                    if($isGuest) {
                                ?>

                                    <div class="form-group">
                                        <input type="text" id="government-ID" class="government-ID" placeholder="Government ID"
                                            value = "<?php echo htmlspecialchars($userExists ? $userData[4] : ""); ?>">
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
                                <!-- CSS Line 94-117 -->
                            </div>
                        </div>
                </div>

                <!-- DATE AND TIME PAGE -->
                <div class="page">
                    <!-- important -->
                    <!-- Put here your codes -->
                    <div class="left_text"><b>SELECT DATE & TIME <font style color="#ffd22d">*</font></b></div>
                    <div class="right_text"><b><font style color="#00b050">AVAILABLE</font>&nbsp;&nbsp;&nbsp;<font style color="#ff0000">FULLY BOOKED</b></font>
                    </div>

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
                        <div class="time">
                            <div>
                                <input type="button" id = "TMSLOT-01" name="btn1" value="08:00 AM" onclick = "load_timeslot(this.id)"/>
                                <input type="button" id = "TMSLOT-02" name="btn2" value="08:30 AM" onclick = "load_timeslot(this.id)"/>
                                <input type="button" id = "TMSLOT-03" name="btn3" value="09:00 AM" onclick = "load_timeslot(this.id)"/>
                            </div>
                            <div>
                                <input type="button" id = "TMSLOT-04" name="btn4" value="09:30 AM" onclick = "load_timeslot(this.id)"/>
                                <input type="button" id = "TMSLOT-05" name="btn5" value="10:00 AM" onclick = "load_timeslot(this.id)"/>
                                <input type="button" id = "TMSLOT-06" name="btn6" value="10:30 AM" onclick = "load_timeslot(this.id)"/>
                            </div>
                            <div>
                                <input type="button" id = "TMSLOT-07" name="btn7" value="11:00 AM" onclick = "load_timeslot(this.id)"/>
                                <input type="button" id = "TMSLOT-08" name="btn8" value="11:30 AM" onclick = "load_timeslot(this.id)"/>
                                <input type="button" id = "TMSLOT-09" name="btn9" value="12:00 PM" onclick = "load_timeslot(this.id)"/>
                            </div>
                            <div>
                                <input type="button" id = "TMSLOT-10" name="btn10" value="12:30 PM" onclick = "load_timeslot(this.id)"/>
                                <input type="button" id = "TMSLOT-11" name="btn11" value="01:00 PM" onclick = "load_timeslot(this.id)"/>
                                <input type="button" id = "TMSLOT-12" name="btn12" value="01:30 PM" onclick = "load_timeslot(this.id)"/>
                            </div>
                            <div>
                                <input type="button" id = "TMSLOT-13" name="btn13" value="02:00 PM" onclick = "load_timeslot(this.id)"/>
                                <input type="button" id = "TMSLOT-14" name="btn14" value="02:30 PM" onclick = "load_timeslot(this.id)"/> 
                                <input type="button" id = "TMSLOT-15" name="btn15" value="03:00 PM" onclick = "load_timeslot(this.id)"/> 
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
                    <h4>APPOINTMENT SUMMARY</h4>
                    <hr></hr>
                    <ul>

                        <!-- Put here the inputted personal information -->
                        <li class="li1"><b>PERSONAL INFORMATION</b></li>

                        <div class="div1">
                            <?php 
                                if($isStudent) {
                                    ?>
                                        <b>Student Number&nbsp;&nbsp;&emsp;&emsp;&emsp;:</b>&nbsp;
                                    <?php
                                } else if($isEmp) {
                                    ?>
                                        <b>Employee Number&nbsp;&nbsp;&emsp;&emsp;&emsp;:</b>&nbsp;
                                    <?php
                                } else {
                                    ?>
                                        <b>Email Address&nbsp;&nbsp;&emsp;&emsp;&emsp;:</b>&nbsp;
                                    <?php
                                }
                            ?>
                            <span id = "visitor-identification"><?php echo htmlspecialchars($fReqData); ?></span><br>
                            <b>Full Name&emsp;&emsp;&emsp;&emsp;&emsp;&ensp; :</b>&nbsp;
                            <span id = "visitor-fname"></span><br>
                            <b>Contact Number&emsp;&ensp; :</b>&nbsp;
                            <span id = "visitor-contact"></span><br>

                            <?php 
                                if($isGuest) {
                                    ?>
                                        <b>Affiliated Company:</b>&nbsp;
                                    <?php
                                } else {
                                    ?>
                                        <b>Email Address :</b>&nbsp;
                                    <?php
                                }
                            ?>
                            <span id = "visitor-email-com"></span><br>
                        </div>

                        <!-- Put here the inputted appointment information -->
                        <li class="li2"><b>APPOINTMENT INFORMATION</b></li>

                        <div class="div2">
                            <div class="column left">
                                <b>RTU Branch&emsp;&ensp;&ensp;:</b>&nbsp;
                                <span id = "visitor-branch"></span><br>
                                <b>Office Name&emsp;&ensp; :</b>&nbsp;
                                <span id = "visitor-office"></span><br>

                                <?php if($isGuest) { ?>
                                    <b>Government ID:</b>&nbsp;
                                    <span id = "visitor-govId"></span>
                                <?php } ?>
                            </div>
                            <div class="column right">
                                <b>Date&emsp;&emsp;&ensp;:</b>&nbsp;
                                <span id = "sched-date"></span><br>
                                <b>Time&emsp;&emsp;&ensp; :</b>&nbsp;
                                <span id = "sched-time"></span><br>
                                <b>PURPOSE&nbsp;:</b>&nbsp;
                                <span id = "sched-purpose"></span><br>
                            </div>
                        </div>

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

                        <button class="submit button1" type="button">Confirm Appointment</button>
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
</body>

</html>
