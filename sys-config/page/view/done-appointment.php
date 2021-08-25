<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");

    $type = null;
    $byTime = 0;

    $appointees_table = getDoneAppointmentsConfig();
    $appointees_size = sizeof($appointees_table);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>All Done Appointments - System Configuration | RTUAppSys</title>

    <link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/css/SA-Interface.css" . FILE_VERSION; ?>">
    <link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/css/fnon.min.css" />

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
                    <img src="../../assets/img/user-icon.png" id="bar-pic">
                </div>
                <!-- //User Image -->
            </div>
            <!-- //User Image Container -->

            <!-- User Name, Title and Line -->
            <div class="name"><?php echo $config_admin_id; ?></div>
            <div class="job">Administrator</div>
            <div class="line"></div>
            <!-- //User Name, Title and Line -->

        </div>
        <!-- //User Image Container -->

        <!-- Navigation List -->
        <ul class="nav-list">
            <li>
				<i class="qr"><img src="../../assets/img/qr_code_scan.svg"></i>
				<input id="searchQR" type="text" placeholder="Search QR Key..." oninput="Typing()">
				<a href="" onclick='return check(this, 1)'>
					<span class="bi bi-arrow-right-short" id="arrow"></span>
				</a>
				<span class="tooltip">Search QR</span>
			</li>
            <li>
                <a href="../main">
                    <i class="bi bi-columns-gap"></i>
                    <span class="links_name">DASHBOARD</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="../office">
                    <i class="bi bi-door-open"></i>
                    <span class="links_name">OFFICES</span>
                </a>
                <span class="tooltip">Offices</span>
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
                <a href="../sys-settings">
                    <i class="bi bi-gear"></i>
                    <span class="links_name">SETTINGS</span>
                </a>
                <span class="tooltip">Settings</span>
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
                            <img src="../../assets/img/user-icon.png" id="bar-pic">
                        </div>
                        <!-- //User Image -->
                    </div>
                    <!-- //User Image Container -->

                    <div class="user-name">
                        <a href="../sys-settings">
                            <h5><?php echo $config_admin_id; ?></h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //Header -->

    <!-- Contents -->
    <main>
    <div class="Appt_area">
        <!-- Contents Container -->
        <div class="contents">
            <div class="main-container">
                <div class="text-container">
                    <h4>All Done Appointments</h4>
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
                            <th style="width: 10%; white-space: nowrap">Office Visited</th>
                            <th>Appointment No.</th>
                            <th>Identification No.</th>
                            <th>Full Name</th>
                            <th>Contact Number</th>
                            <th>Email Address</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Identification Type</th>
                            <th>Date & Time of Visit</th>
                            <th>Source</th>
                        </tr>

            <?php 
                foreach($appointees_table as $appointees) {
                    $date_to_show = new DateTime($appointees[1]);
                    $date_to_show = $date_to_show->format("M d, Y");
                    //$appointees[8] = preg_replace('/\s+/', ' ', $appointees[8]);
                    ?>
            <tr>
                            <td>
                                <?php 
                                    foreach((array)$appointees[6] as $office) {
                                        ?>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-warning"><?php echo htmlspecialchars($office) ?></span>
                                </div>  
                                        <?php
                                    }
                                ?>
                            </td>
                            <td>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-appid"><?php echo htmlspecialchars($appointees[0]); ?></span>
                                </div>  
                            </td>
                            <td><?php echo htmlspecialchars($appointees[9]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[8]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[10]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[11]); ?></td>
                            <td><?php echo htmlspecialchars($date_to_show); ?></td>
                            <td><?php echo htmlspecialchars($appointees[2]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[3]); ?></td> 
                            <td>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-information">
                                <?php 
                                    if($appointees[12] == "student") {
                                        echo "Student (RTU)";
                                    } else if ($appointees[12] == "employee") {
                                        echo "Employee (RTU)";
                                    } else {
                                        echo strtoupper($appointees[12]);
                                    }
                                ?>
                                    </span>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($appointees[5]); ?></td>
                            <td><?php echo htmlspecialchars($appointees[13]); ?></td>
                        </tr>
                    <?php
                }
            ?>
                    </table>
                    <p class="record-count" id="record-count">Total of <?php echo $appointees_size; ?> Done Appointment(s).</p>

                    
                </div>

            </div>
            <div class="button-group-container">
                <div class="done-walk-in-appointments">
                    <a href = "appointment"><i class="bi bi-circle"></i> &nbsp; Ongoing Appointments</a>
                    <a href = "done-appointment" id = "current"><i class="bi bi-check2-circle"></i> &nbsp; Done Appointments</a>
                </div>

                <div class="download-all">
                    <a href = "../download/all-office-visits"><i class="bi bi-download"></i> &nbsp; Download All  Done Appointments</a>
                    <a href = "../download/all-office-visits?month=1"style="position:relative; left:-10px;"><i class="bi bi-download"></i> &nbsp; Download All Records This Month</a>
                </div>
            </div>

        </div>
    </div>
        <!-- //Contents Container -->
    </main>
    <!-- //Contents -->

    <!-- Javascript -->
    <script src="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/js/Admin-Script.js" . FILE_VERSION; ?>"></script>
    <script src="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/js/fnon.min.js"></script>
    <!-- //Javascript -->
    <?php 
        if($is_under_maintenance) {
            echo "<script> Fnon.Alert.Dark({
                message: 'The system is still under maintenance. All users except system administrators are still prohibited to use the system.',
                title: '<strong>Reminder</strong>',
                btnOkText: 'Okay',
                fontFamily: 'Poppins, sans-serif'
            }); </script>";
        }
    ?>                
</body>

</html>
