<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }
    
    $status = 0;

    if($_GET["type"] == 1) {
        $req_sql = "SELECT res.* FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE resValid = 1 AND resStName = 'Arnaiz'";
        $status = 1;
    } else if($_GET["type"] == 2){
        $req_sql = "SELECT res.* FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE resValid = 1 AND resStName = 'Aurora'";
        $status = 2;
    } else if($_GET["type"] == 3){
        $req_sql = "SELECT res.* FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE resValid = 1 AND resStName = 'Tengco'";
        $status = 3;
    } else if($_GET["type"] == 4) {
        $req_sql = "SELECT res.* FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE resValid = 1 AND resStName = 'Tramo'";
        $status = 4;
    } else {
        $req_sql = "SELECT res.* FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE resValid = 1";
    }
    
    $resident_data = selectStatement("r", $req_sql, null);

    $isSubmit = false;
    $isChange_success = false;
    $msg = "";
    $title = "";

    if(isset($_SESSION["admn_update_res"])) {
        $result = $_SESSION["admn_update_res"];
        if($result == 100) {
            $isSubmit = true;
            $isChange_success = true;
        } else if($result == 101) {
            $title = "Cannot Change Username";
            $msg = "There is a problem while processing your request, please try again.";
            $isSubmit = true;
            $isChange_success = false;
        } else if($result == 201) {
            $title = "Incorrect Current Password";
            $msg = "Password does not match the current password.";
            $isSubmit = true;
            $isChange_success = false;
        } else if($result == 202) {
            $title = "Cannot Change Password";
            $msg = "There is a problem while processing your request, please try again.";
            $isSubmit = true;
            $isChange_success = false;
        }

        unset($_SESSION["admn_update_res"]);
    }
?>
<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../global_assets/css/master.css">
        <link rel="stylesheet" href="../assets/css/request.css">
        <link rel="stylesheet" href="../assets/css/profile.css">
        
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
                        <a href="blotter-report">INCIDENT REPORT</a>
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
                        <span class = "request-title"> Barangay Resident </span>
                    </td>
                    <td class = "col-right">
                        <div>
                            <table class = "mini-grid">
                                <tr>
                                    <td>
                                        <input class = "search-field" placeholder = "Search Residents..." id = "txtSearch" onkeyup = "cardSearch()"/>
                                    </td>
                                    <td class = "settings-button">
                                        <span id = "settings"><i class="fa fa-cog" aria-hidden="true"></i></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <hr>
                        <a class = "request-status<?php echo ($status == 0) ? " status-selected" : null?>" href = "barangay-profile">All Residents</a>
                        <a class = "request-status<?php echo ($status == 1) ? " status-selected" : null?>" href = "barangay-profile?type=1">Arnaiz St.</a>
                        <a class = "request-status<?php echo ($status == 2) ? " status-selected" : null?>" href = "barangay-profile?type=2">Aurora St.</a>
                        <a class = "request-status<?php echo ($status == 3) ? " status-selected" : null?>" href = "barangay-profile?type=3">Tengco St.</a>
                        <a class = "request-status<?php echo ($status == 4) ? " status-selected" : null?>" href = "barangay-profile?type=4">Tramo St.</a>
                    </td>
                </tr>
            </table>
            <div class = "outer-wrap">
                <div id = "resident-card" class = "card-wrapper">
    <?php 
        if($resident_data["req_result"]) {
            if($resident_data["req_val"]) {
                $data = $resident_data["req_val"];
                $total_data = count($data);
                $total_row = ceil($total_data / 4);
                $current_col = 0;

                for($i = 0; $i < $total_row; $i++) {
        ?>
                    <div class="row">
                <?php 
                    for($ii = $current_col; ($ii <= $current_col + 3) && ($ii < $total_data); $ii++) {
                        $col_data = $data[$ii];
                        $hash_id = hash('sha256', $col_data["resUname"] . $col_data["sysTime"]);
                ?>
                        <div class="column">
                            <div class="card">
                                <a href = "view-profile?r_id=<?php echo $col_data["resUname"]; ?>"> 
                                    <div class = "row">
                                        <div class = "column col-photo">
                                            <img class = "profile-photo" src = "../../file/load/img?type=view1&r_id=<?php echo $hash_id?>"/>
                                        </div>
                                        <div class = "column col-res-name">
                                            <div class = "card-name"> 
                                                <span class = "last-name">
                                                    <?php echo $col_data["resLname"]; ?> 
                                                </span>
                                                    <?php echo $col_data["resFname"]; ?> 
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                <?php 
                    }
                    $current_col += 4;
                ?>
                    </div>
            <?php
                }
            }
        }
    ?>
                </div>
            </div>
        </div>
        <div id="assign_password" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <table class = "grid-settings-content">
                        <tr>
                            <td colspan = "2">
                                <p class = "modal-header">Settings</p>
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form id = "frm_user" method = "POST" action = "../controllers/admin/change-uname">
                                    <span class = "sys-label">Username:</span>
                                    <input class = "sys-text" id = "txtUsername" name = "Uname" minlength = "7" maxlength = "15" placeholder = "<?php echo $admn_uid; ?>" onchange = "validateUsername(this.value)" required>
                                    <span class = "validate-msg" id = "uname-msg"></span>
                                    <div class = "cell-right">
                                        <input type = "button" class = "sys-modal-button modal-button-2" onclick = "closeModal('assign_password')" value = "Cancel">
                                        <input type = "button" class = "sys-modal-button" id = "btn_user" name = "chng_user" value = "Save">
                                    </div>
                                </form>
                            </td>      
                        </tr>
                        <tr>
                            <td>
                                <form id = "frm_pword" method = "POST" action = "../controllers/admin/change-pword">
                                    <span class = "sys-label">Current Password:</span>
                                    <input type = "password" class = "sys-text" id = "txtCurPassword" name = "curPword" minlength = "8" maxlength = "15" required>
                                    <span class = "sys-label">New Password:</span>
                                    <input type = "password" class = "sys-text" id = "txtPassword" name = "Pword" minlength = "8" maxlength = "15" required>
                                    <span class = "sys-label">Re-enter Password:</span>
                                    <input type = "password" class = "sys-text" id = "txtConPassword" minlength = "8" maxlength = "15" onkeyup = "isPasswordValidated()" required>
                                    <span class = "validate-msg" id = "password-msg"></span>
                                    <div class = "cell-right">
                                        <input type = "button" class = "sys-modal-button modal-button-2" onclick = "closeModal('assign_password')" value = "Cancel">
                                        <input type = "button" class = "sys-modal-button" id = "btn_pword" value = "Save">
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
        </div>
<?php 
    if($isSubmit) {
        if($isChange_success) {
            ?>
            
        <div id = "response_msg" class = "modal modal-alert">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close" onclick = "location.href = '../home'">&times;</span>
                <span class = "modal-header header-lg">Change Username</span>
                <span class = "modal-sub-header header-lg">Username has been successfuly changed.</span>
                <span class = "modal-sub-header header-lg"><?php echo getTimeDate("(F. d, Y - h:m a)"); ?></span>
            </div>
        </div>

            <?php
        } else {
            ?>
            
            <div id = "response_msg" class = "modal modal-alert">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick = "document.getElementById('response_msg').style.display = 'none';">&times;</span>
                    <p class = "modal-header header-lg error"><?php echo $title; ?></p>
                    <p class = "modal-sub-header header-lg"><?php echo $msg; ?></p>
                </div>
            </div>

            <?php
        }
    }
?>
    <!-- /Navigation Bar/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../../global_assets/js/datetime.js"></script>
    <script src="../assets/js/profile.js"></script>
<?php 
    if($isSubmit) {
        ?>
            <script>document.getElementById("response_msg").style.display = "block";</script>
        <?php
    }
?>
</html>