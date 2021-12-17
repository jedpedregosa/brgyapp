<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }
    
    $status = 0;

    if($_GET["type"] == 1) {
        $info_sql = "SELECT * FROM tblBlotterReport WHERE blotterStatus = 2";
        $status = 1;
    } else if($_GET["type"] == 2){
        $info_sql = "SELECT * FROM tblBlotterReport WHERE blotterStatus = 3";
        $status = 2;
    } else if($_GET["type"] == 3){
        $info_sql = "SELECT * FROM tblBlotterReport WHERE blotterStatus = 4";
        $status = 3;
    } else {
        $info_sql = "SELECT * FROM tblBlotterReport WHERE blotterStatus = 1";
    }
    
    $info_data = selectStatement("r", $info_sql, null);
?>
<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../global_assets/css/master.css">
        <link rel="stylesheet" href="../assets/css/request.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body onload="initClock()">
    <!-- Navigation Bar -->
        <!-- CLOCK -->
        <nav class="time">
            <ul class="navbar-nav">
                <!--digital clock start-->
                <div class="datetime">
                    <span id="dayname">Day</span>,
                    <span id="month">Month</span>
                    <span id="daynum">00</span>,
                    <span id="year">Year</span>
                    <span>|</span>
                    <span id="hour">00</span>:
                    <span id="minutes">00</span>:
                    <span id="seconds">00</span>
                    <span id="period">AM</span>
                </div>
                <!--digital clock end-->
                <div class = "uid">
                    <span><?php echo "@" . $admn_uid; ?></span>
                </div>
            </ul>
        </nav>
        <!-- LOGO -->   
        <div class="container">
            <div class="image">
                <img src="../../global_assets/img/LOGO BRGY 108.png" height="150px">
            </div>
            <div class="text">
                <h1 class = "head-title">e-Barangay</h1>
                <h4> <i class = "fa fa-map-marker"></i>&ensp;519 Tengco Street, Pasay City,<br>Metro Manila </h4>
            </div>
            <div class="logo1">
                <img src="../../global_assets/img/facebook.png" height="50px">
            </div>
            <div class="text facebook">
                <a target="blank" href="https://www.facebook.com/Barangay-108-Zone-12-110664607282436/">Barangay Official Account</a>
                <br>
                <a target="blank" href="https://www.facebook.com/skbrgy108/">SK Official Account</a>
            </div>
        </div>
        <!-- NAVIGATION PANEL -->
        <div class="navbar">
            <div class = "nav-button-group">
                <a href="../home"> H O M E </a>
                <a href="../about"> A B O U T </a>
                <a href="../guide"> U S E R - G U I D E </a>
                <div class="dropdown">
                    <button class="dropbtn">E-SERVICES
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="announcements">ANNOUNCEMENTS</a>
                        <a href="health-updates">HEALTH UPDATES</a>
                        <a href="covid-info">COVID-19 INFORMATION</a>
                        <a href="barangay-clearance">REQUESTS</a>
                        <a href="blotter-report">BLOTTER REPORTS</a>
                        <a href="charity-donation">DONATIONS</a>
                        <a href="barangay-profile">PROFILES</a>
                        <a href="../logout">LOG OUT</a>
                    </div>
                </div>
            </div>  
        </div>
        <div class = "content request">
            <table class = "grid">
                <tr>
                    <td>
                        <span class = "request-title"> Incident Report </span>
                    </td>
                    <td class = "col-right">
                        <div>
                            <input class = "search-field" placeholder = "Search Reports..." id = "txtSearch" onkeyup = "searchTable()"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <hr>
                        <a class = "request-status<?php echo ($status == 0) ? " status-selected" : null?>" href = "blotter-report">Unscheduled Cases</a>
                        <a class = "request-status<?php echo ($status == 1) ? " status-selected" : null?>" href = "blotter-report?type=1">Unsettled Cases</a>
                        <a class = "request-status<?php echo ($status == 2) ? " status-selected" : null?>" href = "blotter-report?type=2">Scheduled Cases</a>
                        <a class = "request-status<?php echo ($status == 3) ? " status-selected" : null?>" href = "blotter-report?type=3">Settled Cases</a>
                    </td>
                </tr>
            </table>
            <div class = "side-menu-button">
                <input type = "button" id = "tool_slct" value = "SELECT">
    <?php 
        if($status != 3) {    
            ?>
                <input type = "button" id = "tool_move" value = "MOVE">
    <?php
        } 
            ?>
                <input type = "button" id = "tool_dlte" value = "DELETE">
            </div>
            <div class = "data-wrapper">
                
                <table class = "data-grid" id = "tblBlotter" cellspacing = "0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th colspan = "14">Complainant Information</th>
                            <th colspan = "2">Violation</th>
                            <th colspan = "9">Defendant Information</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Suffix</th>
                            <th>Contact Number</th>
                            <th>Email Address</th>
                            <th>Citizenship</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th colspan = "5">Address <em>(House Number, Street Name, Barangay, Zone, City)</em></th>
                            <th>Date of Crime</th>
                            <th>Incident take place</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Alias</th>
                            <th>Suffix</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>House Number</th>
                            <th>Street</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        
    <?php 
        if($info_data["req_result"]) {
            if($info_data["req_val"]) {
                foreach((array)$info_data["req_val"] as $info) {
                    ?> 
                        <tr>
                            <td><input type = "radio" class = "slct_row" value = "<?php echo $info["blotterId"]; ?>" disabled/></td>
                            <td><?php echo transformDate($info["sysTime"], "m-d-y"); ?></td>
                            <td><?php echo $info["fName"]; ?></td>
                            <td><?php echo $info["mName"]; ?></td>
                            <td><?php echo $info["lName"]; ?></td>
                            <td><?php echo $info["suffix"]; ?></td>
                            <td><?php echo $info["contact"]; ?></td>
                            <td><a href = "<?php echo "mailto:" . $info["email"]; ?>"><?php echo $info["email"]; ?></a></td>
                            <td><?php echo $info["ctzn"]; ?></td>
                            <td><?php echo $info["age"]; ?></td>
                            <td><?php echo $info["sex"]; ?></td>
                            <td><?php echo $info["hNum"]; ?></td>
                            <td><?php echo $info["street"]; ?></td>
                            <td>Barangay 108</td>
                            <td>Zone 12</td>
                            <td>Pasay City</td>
                            <td><?php echo transformDate($info["dateCrime"], "M d, Y"); ?></td>
                            <td><?php echo $info["incident"]; ?></td>
                            <td><?php echo $info["susFname"]; ?></td>
                            <td><?php echo $info["susLname"]; ?></td>
                            <td><?php echo $info["susAlias"]; ?></td>
                            <td><?php echo $info["susSuffix"]; ?></td>
                            <td><?php echo $info["susAge"]; ?></td>
                            <td><?php echo $info["susSex"]; ?></td>
                            <td><?php echo $info["susHnum"]; ?></td>
                            <td><?php echo $info["susStreet"]; ?></td>
                            <td><?php echo $info["reason"]; ?></td>
                        </tr>
                    <?php
                }
            }
        }
    ?>    
                    </tbody>
                </table>
            </div>
        </div>
    <!-- /Navigation Bar/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../../global_assets/js/datetime.js"></script>
    <script src="../assets/js/blotter-report.js"></script>
</html>