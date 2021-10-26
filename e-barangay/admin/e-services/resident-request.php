<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }

    $req_sql = "SELECT res.* FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE resValid = 0";
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
                        <a href="">COVID-19 INFORMATION</a>
                        <a href="barangay-clearance">REQUESTS</a>
                        <a href="">BLOTTER REPORTS</a>
                        <a href="">DONATIONS</a>
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
                        <span class = "request-title"> Barangay Requests </span>
                    </td>
                    <td class = "col-right">
                        <a class = "request-status" href = "barangay-clearance">New Requests</a>
                        <a class = "request-status" href = "">Completed Requests</a>
                        <a class = "request-status status-selected" href = "resident-request">Residents</a>
                    </td>
                </tr>
            </table>
            <hr>
            <div class = "side-menu-button">
                <input type = "button" value = "VIEW">
                <input type = "button" onclick = "window.open('../../guest/sign-up', '_blank').focus();" value = "ADD">
                <input type = "button" id = "tool_slct" value = "SELECT">
                <input type = "button" id = "tool_accpt" value = "ACCEPT">
                <input type = "button" id = "tool_dlte" value = "DELETE">
            </div>
            <div class = "data-wrapper">
                
                <table class = "data-grid" cellspacing = "0">
                    <thead>
                        <th></th>
                        <th>Date</th>
                        <th>Upload</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Suffix</th>
                        <th>Civil Status</th>
                        <th>Citizenship</th>
                        <th>Birthdate<span class = "mini">(M/D/Y)</span></th>
                        <th>Sex</th>
                        <th>House Number</th>
                        <th>Contact Number</th>
                        <th>Email Address</th>
                        <th>Facebook</th>
                        <th>Voter Registration</th>
                        <th>ID (Front & Back)</th>
                        <th>Selfie</th>
                        <th>Signatures</th>
                    </thead>
                    <tbody>
    <?php 
        if($resident_data["req_result"]) {
            if($resident_data["req_val"]) {
                foreach((array)$resident_data["req_val"] as $resident) {
                    $hash_id = hash('sha256', $resident["resUname"] . $resident["sysTime"]);
                    ?>
                        <tr>
                            <td><input type = "radio" class = "slct_row" value = "<?php echo $resident["resUname"]; ?>" disabled/></td>
                            <td><?php echo transformDate($resident["sysTime"], "m-d-y"); ?></td>
                            <td><input type = "button" class = "button-3" 
                                    onclick = "showImgModal('<?php echo $hash_id; ?>', 1)" 
                                    value = "view photo">
                            </td>
                            <td><?php echo $resident["resFname"]; ?></td>
                            <td><?php echo $resident["resMname"]; ?></td>
                            <td><?php echo $resident["resLname"]; ?></td>
                            <td><?php echo $resident["resSuffix"]; ?></td>
                            <td><?php echo getCivilStatus($resident["resCivStat"]); ?></td>
                            <td><?php echo $resident["resCitiznshp"]; ?></td>
                            <td><?php echo transformDate($resident["resBdate"], "m/d/y"); ?></td>
                            <td><?php echo $resident["resSex"]; ?></td>
                            <td><?php echo $resident["resHouseNum"]; ?></td>
                            <td><?php echo $resident["resContact"]; ?></td>
                            <td><?php echo $resident["resEmail"]; ?></td>
                            <td><?php echo $resident["resFbName"]; ?></td>
                            <td><?php echo $resident["resVoter"]; ?></td>
                            <td><input type = "button" class = "button-3" 
                                    onclick = "showImgModal('<?php echo $hash_id; ?>', 2)" 
                                    value = "view ID">
                            </td>
                            <td><input type = "button" class = "button-3" 
                                    onclick = "showImgModal('<?php echo $hash_id; ?>', 3)" 
                                    value = "view selfie">
                            </td>
                            <td><input type = "button" class = "button-3" 
                                    onclick = "showImgModal('<?php echo $hash_id; ?>', 4)" 
                                    value = "view signatures">
                            </td>
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
    <script src="../assets/js/resident-request.js"></script>
</html>