<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Make an Appointment</title>
    <link rel="stylesheet" href="../../assets/css/AppointmentStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
                    <span><img src="Images/app_info_icon_fullwhite.png" title="Location and Purpose"></span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <div class="bullet">
                    <span><img src="Images/date_time.png" title="Date and Time"></span>
                </div>
                <div class="check fas fa-check"></div>
            </div>

            <div class="step">
                <div class="bullet">
                    <span><img src="Images/confirm.png" title="Confirmation"></span>
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
                                <select name="Office" id="Office" class="Office">
                                <option value="" disabled selected hidden>Office</option>
                                <option value="Curriculum and Instructional Resources Development Center">Curriculum and Instructional Resources Development Center</option>
                                <option value="Alumni Relations and Placement Office">Alumni Relations and Placement Office</option>
                                <option value="Disaster Risk Protection Office">Disaster Risk Protection Office</option>
                                <option value="University Data Protection Office">University Data Protection Office</option>
                                <option value="Internal Audit Services Center">Internal Audit Services Center</option>
                                <option value="International Linkages and External Center">International Linkages and External Center</option>
                                <option value="Quality Management System Center">Quality Management System Center</option>
                                <option value="Legal Affairs Office">Legal Affairs Office</option>
                                <option value="Sports Development and Wellness Center">Sports Development and Wellness Center</option>
                                <option value="University Planning Center">University Planning Center</option>
                                <option value="Graduate School">Graduate School</option>
                                <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                                <option value="College of Engineering, Architecture and Technology">College of Engineering, Architecture and Technology</option>
                                <option value="College of Business and Entrepreneurial Technology">College of Business and Entrepreneurial Technology</option>
                                <option value="College of Education">College of Education</option>
                                <option value="Institute of Physical Education">Institute of Physical Education</option>
                                <option value="Senior High School">Senior High School</option>                            <option value="Cooperative Education Center">Cooperative Education Center</option>
                                <option value="Review Center">Review Center</option>
                                <option value="Student Records and Admission Center">Student Records and Admission Center</option>
                                <option value="Guidance Services Center">Guidance Services Center</option>
                                <option value="Medical and Dental Services Center">Medical and Dental Services Center</option>
                                <option value="Center for National Service Training">Center for National Service Training</option>
                                <option value="Center for Student Affairs">Center for Student Affairs</option>
                                <option value="Scholarship and Grant Office">Scholarship and Grant Office</option>
                                <option value="Auxiliary Services Center">Auxiliary Services Center</option>
                                <option value="University Learning Resource Center">University Learning Resource Center</option>
                                <option value="Cultural Affairs Center">Cultural Affairs Center</option>
                                <option value="Administrative Services Center">Administrative Services Center</option>
                                <option value="Financial Services Center">Financial Services Center</option>
                                <option value="Human Resource Development Center">Human Resource Development Center</option>
                                <option value="Management Information Center">Management Information Center</option>
                                <option value="Extension and Community Services Center">Extension and Community Services Center</option>
                                <option value="Gender Studies and Development Center">Gender Studies and Development Center</option>
                                <option value="Intellectual Property Management Center">Intellectual Property Management Center</option>
                                <option value="Research and Development Center">Research and Development Center</option>
                            </select>
                            </div><br><br>
                            <div class="container-office">
                                <select style="width: 150px;">
                                <option value="" disabled selected hidden>RTU Branch</option>
                                <option value="Boni">Boni</option>
                                <option value="Pasig">Pasig</option>
                            </select>
                            </div>
                            <br><br>
                            <div class="container-purpose">
                                <br>
                                <textarea placeholder="State your purpose here..."></textarea>
                            </div>
                            <div class="informationForm">
                                <div class="form-row">
                                    <div class="form-group">
                                        <input type="text" id="student-number" class="student-number" placeholder="Student Number">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" id="first-name" class="first-name" placeholder="First Name ">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" id="last-name" class="last-name" placeholder="Last Name">
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="form-group">
                                        <input type="text" id="contact-number" class="contact-number" placeholder="Contact Number">
                                    </div>


                                    <div class="form-group">
                                        <input type="text" id="email-address" class="email-address" placeholder="Email Address">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" id="government-ID" class="government-ID" placeholder="Government ID">
                                    </div>
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
                                <span class="day_ttl">day</span>
                            </div>
                        </div>

                        <div class="days">
                            <div class="prev-date"></div>
                            <div></div>
                            <div class="next-date"></div>
                        </div>

                        <div class="time">
                            <div>
                                <input type="button" name="btn1" value="08:00 AM" disabled="" />
                                <input type="button" name="btn2" value="08:30 AM" />
                                <input type="button" name="btn3" value="09:00 AM" disabled="" />
                            </div>
                            <div>
                                <input type="button" name="btn4" value="09:30 AM" disabled>
                                <input type="button" name="btn5" value="10:00 AM" />
                                <input type="button" name="btn6" value="10:30 AM" />
                            </div>
                            <div>
                                <input type="button" name="btn7" value="11:00 AM" disabled>
                                <input type="button" name="btn8" value="11:30 AM" disabled />
                                <input type="button" name="btn9" value="12:00 PM" />
                            </div>
                            <div>
                                <input type="button" name="btn10" value="12:30 PM" />
                                <input type="button" name="btn11" value="01:00 PM" />
                                <input type="button" name="btn12" value="01:30 PM" disabled />
                            </div>
                            <div>
                                <input type="button" name="btn13" value="02:00 PM" disabled />
                                <input type="button" name="btn14" value="02:30 PM" disabled />
                                <input type="button" name="btn15" value="03:00 PM" disabled />
                            </div>
                        </div>
                    </div>
                    <script src="JS/cal_script.js"></script>

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
                            <b>Student Number&nbsp;&nbsp;&emsp;&emsp;&emsp;:</b>&nbsp;
                            <!-- Put here the inputted value --><br>
                            <b>FULLNAME&emsp;&emsp;&emsp;&emsp;&emsp;&ensp; :</b>&nbsp;
                            <!-- Put here the inputted value --><br>
                            <b>CONTACT NUMBER&emsp;&ensp; :</b>&nbsp;
                            <!-- Put here the inputted value --><br>
                            <b>Email Address :</b>&nbsp;
                            <!-- Put here the inputted value --><br>
                        </div>

                        <!-- Put here the inputted appointment information -->
                        <li class="li2"><b>APPOINTMENT INFORMATION</b></li>

                        <div class="div2">
                            <div class="column left">
                                <b>RTU BRANCH&emsp;&ensp;&ensp;:</b>&nbsp;
                                <!-- Put here the inputted value --><br>
                                <b>OFFICE NAME&emsp;&ensp; :</b>&nbsp;
                                <!-- Put here the inputted value --><br>
                                <b>GOVERNMENT ID :</b>&nbsp;
                                <!-- Put here the inputted value -->
                            </div>
                            <div class="column right">
                                <b>DATE&emsp;&emsp;&ensp;:</b>&nbsp;
                                <!-- Put here the inputted value --><br>
                                <b>TIME&emsp;&emsp;&ensp; :</b>&nbsp;
                                <!-- Put here the inputted value --><br>
                                <b>PURPOSE&nbsp;:</b>&nbsp;
                                <!-- Put here the inputted value --><br>
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
        <img src="Images/footer.png">
    </div>

    <!-- JAVASCRIPTS USED -->
    <script src="JS/AppointmentScript.js"></script>
</body>

</html>