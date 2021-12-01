<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }

    $req_sql = "SELECT * FROM tblClearance WHERE cStatus = 0";
    
    $isComplete = false;
    if(isset($_GET["type"])) {
        if($_GET["type"] == 1) {
            $req_sql = "SELECT * FROM tblClearance WHERE cStatus = 1";
            $isComplete = true;
        } 
    }

    $resident_data = selectStatement("r", $req_sql, null);
    
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
                        <span class = "request-title"> Barangay Requests </span>
                    </td>
                    <td class = "col-right">
                        <a class = "request-status <?php echo (!$isComplete) ? 'status-selected' : ''?>" href = "barangay-clearance">New Requests</a>
                        <a class = "request-status <?php echo ($isComplete) ? 'status-selected' : ''?>" href = "barangay-clearance?type=1">Completed Requests</a>
                        <a class = "request-status" href = "resident-request">Residents</a>
                    </td>
                </tr>
            </table>
            <hr>
            <table class = "grid top">
                <tr>
                    <td class = "col-menu">
                        <div class="menu">
                    <?php if(!$isComplete) {
                        ?>
                            <a href="barangay-clearance"  class = "module-selected">BARANGAY CLEARANCE</a>
                            <a href="barangay-id-request">BARANGAY IDENTIFICATION (ID)</a>
                            <a href="barangay-indigency-request">BARANGAY INDIGENCY</a>
                            <a href="barangay-burial-request">BURIAL CERTIFICATION</a>
                            <a href="barangay-employment-request">CERTIFICATE OF EMPLOYMENT</a>
                            <a href="barangay-travel-request">CERTIFICATE TO TRAVEL</a>
                            <a href="barangay-residency-request">PROOF OF RESIDENCY</a>
                        <?php
                    } else {
                        ?>
                            <a href="barangay-clearance?type=1"  class = "module-selected">BARANGAY CLEARANCE</a>
                            <a href="barangay-id-request?type=1">BARANGAY IDENTIFICATION (ID)</a>
                            <a href="barangay-indigency-request?type=1">BARANGAY INDIGENCY</a>
                            <a href="barangay-burial-request?type=1">BURIAL CERTIFICATION</a>
                            <a href="barangay-employment-request?type=1">CERTIFICATE OF EMPLOYMENT</a>
                            <a href="barangay-travel-request?type=1">CERTIFICATE TO TRAVEL</a>
                            <a href="barangay-residency-request?type=1">PROOF OF RESIDENCY</a>
                        <?php
                    }
                    ?>
                        </div>
                    </td>
                    <td class = "col-data">
                        
                        <div class = "side-menu-button">
                <?php 
                    if(!$isComplete) {
                        ?>
                            <input type = "button" onclick = "location.href='reports/barangay-clearance'" value = "VIEW">
                            <input type = "button" onclick = "completeClick(8)" value = "COMPLETE">
                        <?php
                    }
                ?> 
                            <input type = "button" onclick = "selectClick()" value = "SELECT">
                            <input type = "button" onclick = "deleteClick(9)" value = "DELETE">
                        </div>
                        <div class = "data-wrapper2">
                            <table class = "data-grid" cellspacing = "0">
                                <thead>
                                    <tr>
                                        <th colspan = "19"  class = "header-title">
                                            <span>Barangay Clearance</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Upload</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Suffix</th>
                                        <th>Citizenship</th>
                                        <th>Civil Status</th>
                                        <th>Birthdate<span class = "mini">(M/D/Y)</span></th>
                                        <th>Sex</th>
                                        <th>House Number</th>
                                        <th>Street Name</th>
                                        <th>Contact Number</th>
                                        <th>Email Address</th>
                                        <th>Facebook</th>
                                        <th>Voter Registration</th>
                                        <th>ID (Front & Back)</th>
                                        <th>Purpose</th>
                                    </tr>
                                </thead>
                                <tbody>
                <?php 
                    if($resident_data["req_result"]) {
                        if($resident_data["req_val"]) {
                            foreach((array)$resident_data["req_val"] as $resident) {
                                $hash_id = hash('sha256', $resident["id"] . $resident["sysTime"]);
                                ?>
                                    <tr>
                                        <td><input type = "radio" class = "slct_row" value = "<?php echo $resident["id"]; ?>" disabled/></td>
                                        <td><?php echo transformDate($resident["sysTime"], "m-d-y"); ?></td>
                                        <td><input type = "button" class = "button-3" 
                                                onclick = "showImgModal('<?php echo $hash_id; ?>', 7)" 
                                                value = "view photo">
                                        </td>
                                        <td><?php echo $resident["fName"]; ?></td>
                                        <td><?php echo $resident["mName"]; ?></td>
                                        <td><?php echo $resident["lName"]; ?></td>
                                        <td><?php echo $resident["sffx"]; ?></td>
                                        <td><?php echo getCivilStatus($resident["civStat"]); ?></td>
                                        <td><?php echo $resident["ctznshp"]; ?></td>
                                        <td><?php echo transformDate($resident["bDate"], "m/d/y"); ?></td>
                                        <td><?php echo $resident["sex"]; ?></td>
                                        <td><?php echo $resident["hNum"]; ?></td>
                                        <td><?php echo $resident["stName"]; ?></td>
                                        <td><?php echo $resident["contact"]; ?></td>
                                        <td><?php echo $resident["email"]; ?></td>
                                        <td><?php echo $resident["fbName"]; ?></td>
                                        <td><?php echo $resident["voter"]; ?></td>
                                        <td><input type = "button" class = "button-3" 
                                                onclick = "showImgModal('<?php echo $hash_id; ?>', 8)" 
                                                value = "view ID">
                                        </td>
                                        <td><?php echo $resident["purpose"]; ?></td>
                                    </tr>
                                <?php
                            }
                        }
                    }
                ?>    
                                </tbody>
                            </table>
                        </div>    
                    </td>
                </tr>
            </table>
        </div>
        <!-- The Modal -->
        <div id="res_img_modal" class="img-modal">

            <!-- The Close Button -->
            <span class="img-close">&times;</span>

            <!-- Modal Content (The Image) -->
            <img class="img-modal-content" id="sample_photo">

            <!-- Modal Caption (Image Text) -->
            <div id="img_caption"></div>
        </div>
    <!-- /Navigation Bar/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../../global_assets/js/datetime.js"></script>
    <script src="../assets/js/request.js"></script>
</html>