<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");
    
    if(!$is_resdnt_lgn) {
        header("Location: ../logout");
        exit();    
    }


    $res_val = [];

    $req_sql = "SELECT res.* FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE res.resUname = ?";
    $resident_data = selectStatement("f", $req_sql, [$resdnt_uid]);

    if($resident_data["req_result"]) {
        if($resident_data["req_val"]) {
            $res_val = $resident_data["req_val"];
        } else {
            invalidUserFound();
        }
    } else {
        invalidUserFound();
    }

    $hash_id = hash('sha256', $res_val["resUname"] . $res_val["sysTime"]);

    function invalidUserFound() {
        header("Location: ../home");
        exit();
    }

    $isSubmit = false;
    $isChange_success = false;
    $msg = "";
    $title = "";

    if(isset($_SESSION["res_update_set"])) {
        $result = $_SESSION["res_update_set"];
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
        } else if($result == 301) {
            $title = "Cannot Update Profile";
            $msg = "There is a problem while processing your request, please try again.";
            $isSubmit = true;
            $isChange_success = false;
        }
        unset($_SESSION["res_update_set"]);
    }
?>
<html>
    <head>
        <title>e-Barangay - <?php echo $res_val["resLname"] . ", " . $res_val["resFname"]; ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../global_assets/css/master.css">
        <link rel="stylesheet" href="../../global_assets/css/sign-up.css">
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
    <?php 
        if($is_resdnt_lgn) {
            ?>
                <div class = "uid">
                    <span><?php echo "@" . $resdnt_uid; ?></span>
                </div>
            <?php
        }
    ?>     
       
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
    <?php 
        if($is_resdnt_lgn) {
            ?>
                <div class="dropdown">
                    <button class="dropbtn">E-SERVICES
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="barangay-clearance">BARANGAY CLEARANCE</a>
                        <a href="barangay-id-form">BARANGAY IDENTIFICATION (ID)</a>
                        <a href="barangay-indigency">BARANGAY INDIGENCY</a>
                        <a href="barangay-burial-cert">BURIAL CERTIFICATION</a>
                        <a href="barangay-employment-form">CERTIFICATE OF EMPLOYMENT</a>
                        <a href="barangay-travel-cert">CERTIFICATE TO TRAVEL</a>
                        <a href="barangay-proof-res">PROOF OF RESIDENCY</a>
                        <a href="barangay-blotter-report">INCIDENT REPORT</a>
                        <a></a>
                        <a href="view-profile"><strong>PROFILE</strong></a>
                        <a href="../logout">LOG OUT</a>
                    </div>
                </div>
    <?php 
        } else {
            ?>
                <a href="../login"> L O G I N / S I G N U P </a>
            <?php
        }        
    ?>
            </div>  
        </div>
    <!-- /Navigation Bar/ -->
    <!-- Content -->
        <form id = "frm_acc" method = "POST" action = "../controllers/acc/update-account" enctype="multipart/form-data">
            <div class = "content profile-adjust">
                <div class = "create-account">
                    <div class = "col-right">
                        <span id = "settings"><i class="fa fa-cog" aria-hidden="true"></i></span>
                    </div>
                    <h3 class = "title">R E S I D E N T &ensp; P R O F I L E</h3>
                    <table class = "grid">
                        <tr>
                            <td class = "cell-pic">
                                <img class = "img-button profile-pic" src="../../file/load/img?type=view1&r_id=<?php echo $hash_id?>" id = "uploaded_dp">
                            </td>
                            <td class = "cell-info">
                                <table class = "main-grid">
                                    <tr>
                                        <td>
                                            <span class = "sys-label">First Name </span>
                                            <input class = "sys-text" name = "Fname" id = "Fname" minlength = "2" maxlength = "25" value = "<?php echo $res_val["resFname"]; ?>" required readonly>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Middle Name</span>
                                            <input class = "sys-text" name = "Mname" id = "Mname" maxlength = "25" value = "<?php echo $res_val["resMname"]; ?>" readonly>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Last Name </span>
                                            <input class = "sys-text" name = "Lname" id = "Lname" minlength = "2" value = "<?php echo $res_val["resLname"]; ?>" maxlength = "25" required readonly>
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Suffix</span>
                                            <input class = "sys-text" name = "Suffix" id = "Suffix" maxlength = "5" value = "<?php echo $res_val["resSuffix"]; ?>" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class = "sys-label">Civil Status </span>
                                            <select class = "sys-text" id = "CivStat" name = "CivStat" required disabled>
                                                <option value = "1" <?php echo ($res_val["resCivStat"] == 1) ? "selected": ''; ?>> Single</option>
                                                <option value = "2" <?php echo ($res_val["resCivStat"] == 2) ? "selected": ''; ?>> Married</option>
                                                <option value = "3" <?php echo ($res_val["resCivStat"] == 3) ? "selected": ''; ?>> Divorced</option>
                                                <option value = "4" <?php echo ($res_val["resCivStat"] == 4) ? "selected": ''; ?>> Separated</option>
                                                <option value = "5" <?php echo ($res_val["resCivStat"] == 5) ? "selected": ''; ?>> Widowed</option>
                                            </select>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Citizenship </span>
                                            <input class = "sys-text" name = "Ctznshp" id = "Ctznshp" min = "2" maxlength = "25" value = "<?php echo $res_val["resCitiznshp"]; ?>" required readonly>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Birthdate <span class = "sys-label sub-lbl">(Month, Day, Year)</span> </span>
                                            <input type = "date" class = "sys-text" name = "Bdate" id = "Bdate" value = "<?php echo $res_val["resBdate"]; ?>" required readonly>
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Sex </span>
                                            <select class = "sys-text" name = "Sex" id = "Sex" required disabled>
                                                <option value = "M" <?php echo ($res_val["resSex"] == 'M') ? "selected" : ''; ?>>M</option>
                                                <option value = "F" <?php echo ($res_val["resSex"] == 'F') ? "selected" : ''; ?>>F</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2">
                                <table class = "main-grid">
                                    <tr>
                                        <td colspan = "5">
                                            <span class = "sys-label">Address <span class = "sys-label sub-lbl">(House Number, Street Name, Barangay, Zone, City)</span> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class = "col-sm">
                                            <input class = "sys-text" name = "HouseNum" id = "HouseNum" maxlength = "25" value = "<?php echo $res_val["resHouseNum"]; ?>" required readonly>
                                        </td>
                                        <td>
                                            <select class = "sys-text" name = "StName" id = "StName" required disabled>
                                                <option value = "Tengco" <?php echo ($res_val["resStName"] == 'Tengco') ? "selected" : ''; ?>> Tengco</option>
                                                <option value = "Aurora" <?php echo ($res_val["resStName"] == 'Aurora') ? "selected" : ''; ?>> Aurora</option>
                                                <option value = "Arnaiz" <?php echo ($res_val["resStName"] == 'Arnaiz') ? "selected" : ''; ?>> Arnaiz</option>
                                                <option value = "Tramo" <?php echo ($res_val["resStName"] == 'Tramo') ? "selected" : ''; ?>> Tramo</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class = "sys-text" value = "Barangay 108" disabled>
                                        </td>
                                        <td>
                                            <input class = "sys-text" value = "Zone 12" disabled>
                                        </td>
                                        <td>
                                            <input class = "sys-text" value = "Pasay City" disabled>
                                        </td>
                                    </tr>
                                </table>
                                <table class = "main-grid">
                                    <tr>
                                        <td>
                                            <span class = "sys-label">Contact Number </span>
                                            <input class = "sys-text" name = "Contact" id = "Contact" maxlength = "11" value = "<?php echo $res_val["resContact"]; ?>" onchange = "validateUsername(this.value, 'a')" required readonly>
                                            <span class = "validate-msg" id = "cntct-msg"></span>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Email Address </span>
                                            <input type = "email" class = "sys-text" name = "Email" id = "Email" maxlength = "50" value = "<?php echo $res_val["resEmail"]; ?>" onchange = "validateUsername(this.value, 'c')" required readonly>
                                            <span class = "validate-msg" id = "email-msg"></span>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Facebook Name</span>
                                            <input class = "sys-text" name = "FbName" id = "FbName" maxlength = "25" value = "<?php echo $res_val["resFbName"]; ?>" readonly>
                                        </td>
                                        <td>
                                            <span class = "sys-label"><em>Registered Voter?</em></span>
                                            <input class = "sys-text" name = "Voter" id = "Voter" maxlength = "25" value = "<?php echo $res_val["resVoter"]; ?>" readonly>
                                        </td>
                                        <td>
                                            <label class = "sys-chck-label">
                                                <span class = "sys-label"><em>Select:</em></span>
                                                <input type = "checkbox" name = "isPwd" id = "isPwd" <?php echo ($res_val["isPWD"]) ? 'checked' : ''; ?> disabled> Are you a PWD? 
                                            </label>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    
                    <input class = "sys-button button-2" onclick = "location.href='../home'" value = "C A N C E L">
                    <input type = "button" class = "sys-button" id = "btn_edit" value = "E D I T">
                    <input type = "button" class = "sys-button" id = "btn_save" value = "S A V E">
                </div>
            </div>
        </form>
    <!-- /Content/ -->
        <div id="assign_password" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <table class = "grid2">
                        <tr>
                            <td colspan = "2">
                                <p class = "modal-header">Settings</p>
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form id = "frm_user" method = "POST" action = "../controllers/acc/change-uname">
                                    <span class = "sys-label">Username:</span>
                                    <input class = "sys-text" id = "txtUsername" name = "Uname" minlength = "7" maxlength = "15" placeholder = "<?php echo $resdnt_uid; ?>" onchange = "validateUsername(this.value, 'b')" required>
                                    <span class = "validate-msg" id = "uname-msg"></span>
                                    <div class = "col-right">
                                        <input type = "button" class = "sys-modal-button modal-button-2" onclick = "closeModal('assign_password')" value = "Cancel">
                                        <input type = "button" class = "sys-modal-button" id = "btn_user" name = "chng_user" value = "Save">
                                    </div>
                                </form>
                            </td>      
                        </tr>
                        <tr>
                            <td>
                                <form id = "frm_pword" method = "POST" action = "../controllers/acc/change-pword">
                                    <span class = "sys-label">Current Password:</span>
                                    <input type = "password" class = "sys-text" id = "txtCurPassword" name = "curPword" minlength = "8" maxlength = "15" required>
                                    <span class = "sys-label">New Password:</span>
                                    <input type = "password" class = "sys-text" id = "txtPassword" name = "Pword" minlength = "8" maxlength = "15" required>
                                    <span class = "sys-label">Re-enter Password:</span>
                                    <input type = "password" class = "sys-text" id = "txtConPassword" minlength = "8" maxlength = "15" onkeyup = "isPasswordValidated()" required>
                                    <span class = "validate-msg" id = "password-msg"></span>
                                    <div class = "col-right">
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
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../../global_assets/js/datetime.js"></script>
    <script src="../assets/js/update-cred.js"></script>

    <?php 
        if($isSubmit) {
            ?>
                <script>
                    openModal("response_msg");
                </script>
            <?php
        }
    ?>
</html>