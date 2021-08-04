<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Appointments</title>

    <link rel="stylesheet" href="../../assets/css/OA-TableStyle.css">
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
                    <img src="../../assets/img/user-icon.png" id="bar-pic">
                </div>
                <!-- //User Image -->
            </div>
            <!-- //User Image Container -->

            <!-- User Name, Title and Line -->
            <div class="name">Kassy Meatloaf</div>
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
                <a href="../dashboard">
                    <i class="bi bi-columns-gap"></i>
                    <span class="links_name">DASHBOARD</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="javascript:window.location.reload(true)" class="active">
                    <i class="bi bi-calendar3"></i>
                    <span class="links_name">APPOINTMENTS</span>
                </a>
                <span class="tooltip">Appointments</span>
            </li>
            <li>
                <a href="OA-Table-Feedback.html">
                    <i class="bi bi-star"></i>
                    <span class="links_name">FEEDBACK</span>
                </a>
                <span class="tooltip">Feedback</span>
            </li>
            <li>
                <a href="OA-Profile.html">
                    <i class="bx bx-user"></i>
                    <span class="links_name">PROFILE</span>
                </a>
                <span class="tooltip">Profile</span>
            </li>
            <div class="line2"></div>

            <li class="logout">
                <i class='bi bi-box-arrow-right' id="log_out"></i>
                <span class="logout-label">Logout</span>
            </li>
        </ul>
        <!-- //Navigation List -->

    </div>
    <!-- //Side Navigation Bar -->

    <!-- Header -->
    <section class="header-section">
        <div class="header-border">
            <div class="header">
                <div class="sys-title">
                    <img src="../../assets/img/menu.png" id="btn"> RTU APPOINTMENT SYSTEM
                    <!-- Add here the office name -->
                </div>

                <div class="user-wrapper">
                    <!-- User Image Container -->
                    <div class="header-user-con">

                        <!-- User Image -->
                        <div class="header-user-img">
                            <img src="../../assets/img/user-icon.png" id="header-pic">
                        </div>
                        <!-- //User Image -->
                    </div>
                    <!-- //User Image Container -->

                    <div class="user-name">
                        <a href="OA-Profile.html">
                            <h5>Kassy Meatloaf</h5>
                        </a>
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
            <div class="main-container">
                <div class="text-container">
                    <h4>APPOINTMENTS</h4>
                </div>

                <div class="select-input-container">
                    <select class="select-table">
                        <option value="" hidden selected disabled>Select Table</option>
                        <option value="Student">Student</option>
                        <option value="Employee">Employee</option>
                        <option value="Guest">Guest</option>
                    </select>
                    <select class="select-display">
                        <option value="" hidden disabled selected>View By</option>
                        <option value="">Default</option>
                    </select>
                    <input type="text" name="" id="" class="search-bar" placeholder="Search">
                    <input type="button" value="" class="search-button">
                </div>

                <div class="table-container">
                    <table>
                        <tr class="table-header">
                            <th>Appointment #</th>
                            <th>Appointment ID</th>
                            <th>Employee Number</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Contact Number</th>
                            <th>Email Address</th>
                            <th>RTU Branch</th>
                            <th>Office</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Government ID</th>

                        </tr>

                        <tr>
                            <td>0001</td>
                            <td>101121421</td>
                            <td>2018-104965</td>
                            <td>Enteria</td>
                            <td>Neilvin</td>
                            <td>09983981223</td>
                            <td>Neilvinenteria@gmail.com</td>
                            <td>Boni</td>
                            <td>Student Affairs</td>
                            <td>July 24, 2021</td>
                            <td>10:30AM - 11:00AM</td>
                            <td>Document Submission</td>
                            <td>RTU Student ID</td>

                        </tr>
                        <tr>
                            <td>0001</td>
                            <td>101121421</td>
                            <td>2018-104965</td>
                            <td>Enteria</td>
                            <td>Neilvin</td>
                            <td>09983981223</td>
                            <td>Neilvinenteria@gmail.com</td>
                            <td>Boni</td>
                            <td>Student Affairs</td>
                            <td>July 24, 2021</td>
                            <td>10:30AM - 11:00AM</td>
                            <td>Document Submission</td>
                            <td>RTU Student ID</td>


                        </tr>
                        <tr>
                            <td>0001</td>
                            <td>101121421</td>
                            <td>2018-104965</td>
                            <td>Enteria</td>
                            <td>Neilvin</td>
                            <td>09983981223</td>
                            <td>Neilvinenteria@gmail.com</td>
                            <td>Boni</td>
                            <td>Student Affairs</td>
                            <td>July 24, 2021</td>
                            <td>10:30AM - 11:00AM</td>
                            <td>Document Submission</td>
                            <td>RTU Student ID</td>

                        </tr>
                        <tr>
                            <td>0001</td>
                            <td>101121421</td>
                            <td>2018-104965</td>
                            <td>Enteria</td>
                            <td>Neilvin</td>
                            <td>09983981223</td>
                            <td>Neilvinenteria@gmail.com</td>
                            <td>Boni</td>
                            <td>Student Affairs</td>
                            <td>July 24, 2021</td>
                            <td>10:30AM - 11:00AM</td>
                            <td>Document Submission</td>
                            <td>RTU Student ID</td>

                        </tr>
                    </table>
                    <p class="record-count" id="record-count">Number of Records: </p>
                </div>

            </div>


        </div>
        <!-- //Contents Container -->
    </main>
    <!-- //Contents -->

    <!-- Javascript -->
    <script src="../../assets/js/OA-TableScript.js"></script>
    <!-- //Javascript -->

</body>

</html>