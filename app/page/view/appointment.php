<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    $type = null;
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

    <title>Appointments - RTU Appointment System</title>

    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_PROTOCOL . HOST . "/app/assets/css/OA-Interface.css" . FILE_VERSION ?>">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
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
                    <img src="load_image" id="bar-pic" alt="Not Found" onerror="this.src='../../assets/img/user-icon.png'">
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
                <a href="feedback">
                    <i class="bi bi-star"></i>
                    <span class="links_name">FEEDBACK</span>
                </a>
                <span class="tooltip">Feedback</span>
            </li>
            <li>
                <a href="../profile">
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
                            <img src="load_image" id="header-pic" alt="Not Found" onerror="this.src='../../assets/img/user-icon.png'">
                        </div>
                        <!-- //User Image -->
                    </div>
                    <!-- //User Image Container -->

                    <div class="user-name">
                        <a href="../profile">
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

                
                <div class="functions-container">

                <div class="select-1-container">
                    <select class="select-table" id = "slct_class" onchange="sortTable(this)">
                        <option value="" <?php echo ($hasNoClass ? "selected" : "");?>>View All Class</option>
                        <option value="student" <?php echo ($isStudent ? "selected" : "");?>>By Student</option>
                        <option value="employee"<?php echo ($isEmployee ? "selected" : "");?>>By Employee</option>
                        <option value="guest"<?php echo ($isGuest ? "selected" : "");?>>By Guest</option>
                    </select>
                </div>

                    <div class="select-2-container">
                        <!--Add Select View By Here-->
                        <select class="select-display" id = "slct_tmestmp" onchange="sortTableBy(this)">
                            <option value="" <?php echo ($hasNoStamp ? "selected" : "");?>>View All Dates</option>
                            <option value="today" <?php echo ($byToday ? "selected" : "");?>>Appointments Today</option>
                            <option value="week" <?php echo ($byWeek ? "selected" : "");?>>This Week</option>
                        </select>
                    </div>

                    <div class="search-bar-container">
                        <!--Add Search Bar Here-->
                        <input type="text" class="searchTerm" id = "txt_search" placeholder="Search" onkeyup= "searchTable()">
                        <button class="searchButton" disabled>
                          <i class="bi bi-search"></i>
                        </button>
                    </div>

                </div>

                <div class="table-container">
                    <table id = "tbl_appointments">
                        <tr class="table-header">
                            <th style="width: 10%;">Appointment No.</th>
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
                            <th>Identification Type</th>
                            <th>Status</th>
                        </tr>

            <?php 
                foreach($appointees_table as $appointees) {
                    $date_to_show = new DateTime($appointees[6]);
                    $date_to_show = $date_to_show->format("M d, Y");
                    //$appointees[8] = preg_replace('/\s+/', ' ', $appointees[8]);
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
                            <td>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-information">
                                <?php 
                                    if($appointees[9] == "student") {
                                        echo "Student (RTU)";
                                    } else if ($appointees[9] == "guest") {
                                        echo "GOV ID";
                                    } else {
                                        echo "Employee (RTU)";
                                    }
                                ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <?php
                                    if($appointees[10]) {
                                        ?>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-success">Available</span>
                                </div>
                                        <?php
                                    } else {
                                        ?>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-error">Closed</span>
                                </div>
                                        <?php
                                    }
                                ?>
                                
                            </td> 
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
