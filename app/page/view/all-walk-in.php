<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    $type = null;
    $byTime = 0;

    $appointees_table = getWalkinAppointments($assigned_office);
    $appointees_size = sizeof($appointees_table);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Walk-in Appointments - RTU Appointment System</title>

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
				<i class="qr"><img src="../../assets/img/qr_code_scan.svg"></i>
				<input id="searchQR" type="text" placeholder="Search QR Key..." oninput="Typing()">
				<a href="" onclick='return check(this)'>
					<span class="bi bi-arrow-right-short" id="arrow"></span>
				</a>
				<span class="tooltip">Search QR</span>
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
                    <h4>Walk-in Appointments</h4>
                </div>

                
                <div class="functions-container">

                    <div class="search-bar-container">
                        <!--Add Search Bar Here-->
                        <input type="text" class="searchTerm" id = "txt_search" placeholder="Search" onkeyup= "searchTable(0, this.value)">
                        <button class="searchButton" disabled>
                          <i class="bi bi-search"></i>
                        </button>
                    </div>

                </div>

                <div class="table-container">
                    <table id = "tbl_appointments">
                        <tr class="table-header">
                            <th style="width: 10%;">Appointment No.</th>
                            <th>Identification No.</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Contact Number</th>
                            <th>Email Address</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Identification Type</th>
                            <th>Date & Time of Walk-in Visit</th>
                        </tr>

            <?php 
                foreach($appointees_table as $appointees) {
                    $date_to_show = new DateTime($appointees[1]);
                    $date_to_show = $date_to_show->format("M d, Y");
                    //$appointees[8] = preg_replace('/\s+/', ' ', $appointees[8]);
                    ?>
            <tr>
                            <td>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-appid"><?php echo htmlspecialchars($appointees[0]); ?></span>
                                </div>    
                            </td>
                            <td><?php echo htmlspecialchars($appointees[8]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[6]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[7]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[9]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[10]); ?></td>
                            <td><?php echo htmlspecialchars($date_to_show); ?></td>
                            <td><?php echo htmlspecialchars($appointees[2]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[3]); ?></td>
                            <td>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-information">
                                <?php 
                                    if($appointees[11] == "student") {
                                        echo "Student (RTU)";
                                    } else if ($appointees[11] == "employee") {
                                        echo "Employee (RTU)";
                                    } else {
                                        echo strtoupper($appointees[11]);
                                    }
                                ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <?php
                                    echo $appointees[5];
                                ?>
                                
                            </td> 
                        </tr>
                    <?php
                }
            ?>
                    </table>
                    <p class="record-count" id="record-count">Total of <?php echo $appointees_size; ?> Walk-in Visit(s).</p>

                    
                </div>

            </div>

            <div class="buttons-container">
                <div class="buttons-left">
                    <a href="appointment"><i class="bi bi-circle"></i> &nbsp; On-going Appointments</a>
                    <a href="done"><i class="bi bi-check2-circle"></i> &nbsp; Done Appointments</a>
                    <a href="all-walk-in" id="current"><i class="bi bi-door-closed"></i> &nbsp; Walk-in Appointments</a>
                </div>

                <div class="buttons-right">
                    <a href="../download/all_walkin_app" class="download"><i class="bi bi-download"></i> &nbsp; Download All Walk-in Appointments</a>    
                </div>
            </div>

        </div>
        <!-- //Contents Container -->
    </main>
    <!-- //Contents -->

    <!-- Javascript -->
    <script src="<?php echo HTTP_PROTOCOL . HOST . "/app/assets/js/OA-TableScript.js" . FILE_VERSION; ?>"></script>
    <!-- //Javascript -->

</body>

</html>
