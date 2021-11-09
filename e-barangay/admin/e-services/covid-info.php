<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }
    
    $not_last = true;
    $is_rec = false;
    $info_sql;

    if($_GET["type"] == 1) {
        $info_sql = "SELECT * FROM tblCovidInfo WHERE covStatus = 2";
        $is_rec = true;
    } else if($_GET["type"] == 2){
        $info_sql = "SELECT * FROM tblCovidInfo WHERE covStatus = 3";
        $not_last = false;
    } else {
        $info_sql = "SELECT * FROM tblCovidInfo WHERE covStatus = 1";
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
                        <a href="">PROFILES</a>
                        <a href="../logout">LOG OUT</a>
                    </div>
                </div>
            </div>  
        </div>
        <div class = "content request">
            <table class = "grid">
                <tr>
                    <td>
                        <span class = "request-title"> Covid-19 Information </span>
                    </td>
                    <td class = "col-right">
                        <a class = "request-status<?php echo ($not_last && !$is_rec) ? " status-selected" : null?>" href = "covid-info">Active</a>
                        <a class = "request-status<?php echo ($is_rec) ? " status-selected" : null?>" href = "covid-info?type=1">Recover</a>
                        <a class = "request-status<?php echo (!$not_last) ? " status-selected" : null?>" href = "covid-info?type=2">Death</a>
                    </td>
                </tr>
            </table>
            <hr>
            <div class = "side-menu-button">
                <input type = "button" onclick = "window.location.href='add-covid-info'" value = "ADD">
                <input type = "button" id = "tool_slct" value = "SELECT">
    <?php 
        if($not_last) {    
            ?>
                <input type = "button" id = "tool_move" value = "MOVE">
    <?php
        } 
            ?>
                <input type = "button" id = "tool_dlte" value = "DELETE">
            </div>
            <div class = "data-wrapper">
                
                <table class = "data-grid" cellspacing = "0">
                    <thead>
                        <th></th>
                        <th>Date</th>
                        <th></th>
                        <th>Type of Covid</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Suffix</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Citizenship</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>House No.</th>
                        <th>Street Name</th>
                        <th>Date Admitted</th>
                        <th>Date Discharged</th>
                        <th>Quarantine Start</th>
                        <th>Quarantine End</th>
                    </thead>
                    <tbody>
    <?php 
        if($info_data["req_result"]) {
            if($info_data["req_val"]) {
                foreach((array)$info_data["req_val"] as $info) {
                    ?> 
                        <tr>
                            <td><input type = "radio" class = "slct_row" value = "<?php echo $info["infoId"]; ?>" disabled/></td>
                            <td><?php echo transformDate($info["sysTime"], "m-d-y"); ?></td>
                            <td></td>
                            <td><?php echo $info["covType"]; ?></td>
                            <td><?php echo $info["fName"]; ?></td>
                            <td><?php echo $info["mName"]; ?></td>
                            <td><?php echo $info["lName"]; ?></td>
                            <td><?php echo $info["suffix"]; ?></td>
                            <td><?php echo $info["contact"]; ?></td>
                            <td><?php echo $info["email"]; ?></td>
                            <td><?php echo $info["ctznshp"]; ?></td>
                            <td><?php echo $info["age"]; ?></td>
                            <td><?php echo $info["sex"]; ?></td>
                            <td><?php echo $info["hNum"]; ?></td>
                            <td><?php echo $info["stName"]; ?></td>
                            <td><?php echo $info["dateAd"]; ?></td>
                            <td><?php echo $info["dateDis"]; ?></td>
                            <td><?php echo $info["dateStart"]; ?></td>
                            <td><?php echo $info["dateEnd"]; ?></td>
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
    <script src="../assets/js/covid-info.js"></script>
</html>