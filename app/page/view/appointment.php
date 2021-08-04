<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");

    $type;
    $byTime = 0;

    $isStudent = false;
    $isEmployee = false;
    $isGuest = false;
    $hasNoClass = true;

    $byToday = false;
    $byWeek = false;
    $hasNoStamp = true;

    if(isset($_GET["class"])) {
        $hasNoClass = false;
        $class = $_GET["class"];
        if($class == "student") {
            $isStudent = true;
        } else if($class == "employee") {
            $isEmployee = true;
        } else if ($class == "guest") {
            $isGuest = true;
        } else {
            header("Location: appointment");
            die();
        }
        $type = $class;
    }

    if(isset($_GET["by"])) {
        $hasNoStamp = false;
        $by = $_GET["by"]; 
        if($by == "today") {
            $byTime = 1;
            $byToday = true;
        } else if($by == "week") {
            $byTime = 7;
            $byWeek = true;
        } else {
            header("Location: appointment");
            die();
        }

    }

    $appointees_table = getAllAppointments($assigned_office, $type, $byTime);
    $appointees_size = sizeof($appointees_table);

?>
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
                <a href="../dashboard">
                    <i class="bi bi-columns-gap"></i>
                    <span class="links_name">DASHBOARD</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="javascript:window.location.reload(true)" class="active">
                    <i class="bi bi-calendar3"></i>
                    <span class="links_name"> APPOINTMENTS</span>
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
            <a href = "../logout">
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
                            <h5><?php echo htmlspecialchars($full_name); ?></h5>
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
                    <h4>
                        <?php 
                            if($isStudent) {
                                echo "Student Appointments";
                            } else if($isEmployee) {
                                echo "Employee Appointments";
                            } else if($isGuest) {
                                echo "Guest Appointments";
                            } else {
                                echo "All Appointments";
                            }
                        ?>
                    </h4>
                </div>

                <div class="select-input-container">
                    <select class="select-table" id = "slct_class" onchange="sortTable(this)">
                        <option value="" <?php echo ($hasNoClass ? "selected" : "");?>>View All</option>
                        <option value="student" <?php echo ($isStudent ? "selected" : "");?>>Student</option>
                        <option value="employee"<?php echo ($isEmployee ? "selected" : "");?>>Employee</option>
                        <option value="guest"<?php echo ($isGuest ? "selected" : "");?>>Guest</option>
                    </select>
                    <select class="select-display" id = "slct_tmestmp" onchange="sortTableBy(this)">
                        <option value="" <?php echo ($hasNoStamp ? "selected" : "");?>>View All Dates</option>
                        <option value="today" <?php echo ($byToday ? "selected" : "");?>>Appointments Today</option>
                        <option value="week" <?php echo ($byWeek ? "selected" : "");?>>This Week</option>
                    </select>
                    <div class="search-bar-container">
                        <!--Add Search Bar Here-->
                        <input type="text" class="searchTerm" id = "txt_search" placeholder="Search" onkeyup= "searchTable()">
                    </div>
                </div>

                <div class="table-container">
                    <table id = "tbl_appointments">
                        <tr class="table-header">
                            <th>Appointment No.</th>
                <?php 
                    if($isStudent) {
                        ?>
                            <th>Student No.</th>
                        <?php
                    } else if($isEmployee) {
                        ?>
                            <th>Employee No.</th>
                        <?php
                    } else {
                        ?>
                            <th>Identification No.</th>
                        <?php
                    }
                ?>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Contact Number</th>
                            <th>Email Address</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Type</th>
                        </tr>

            <?php 
                foreach($appointees_table as $appointees) {
                    $date_to_show = new DateTime($appointees[6]);
                    $date_to_show = $date_to_show->format("M d, Y");
                    ?>
            <tr>
                            <td><?php echo htmlspecialchars($appointees[0]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[1]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[2]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[3]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[4]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[5]); ?></td>
                            <td><?php echo htmlspecialchars($date_to_show); ?></td>
                            <td><?php echo htmlspecialchars($appointees[7]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[8]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[9]); ?></td>
                        </tr>
                    <?php
                }
            ?>
                    </table>
        <?php 
            if($isStudent) {
                ?>
                    <p class="record-count" id="record-count">Total of <?php echo $appointees_size; ?> appointments from students. </p>
                <?php
            } else if($isEmployee) {
                ?>
                    <p class="record-count" id="record-count">Total of <?php echo $appointees_size; ?> appointments from employees. </p>
                <?php
            } else {
                ?>
                    <p class="record-count" id="record-count">Total of <?php echo $appointees_size; ?> appointees.</p>
                <?php
            }
        ?>
                    
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