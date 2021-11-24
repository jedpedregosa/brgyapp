<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }


    $res_val = [];
    if(isset($_GET["r_id"])) {
        $res_id = $_GET["r_id"];

        $req_sql = "SELECT res.* FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE resValid = 1 AND res.resUname = ?";
        $resident_data = selectStatement("f", $req_sql, [$res_id]);

        if($resident_data["req_result"]) {
            if($resident_data["req_val"]) {
                $res_val = $resident_data["req_val"];
            } else {
                invalidUserFound();
            }
        } else {
            invalidUserFound();
        }
    } else {
        invalidUserFound();
    }

    $hash_id = hash('sha256', $res_val["resUname"] . $res_val["sysTime"]);

    function invalidUserFound() {
        header("Location: barangay-profile");
        exit();
    }
?>
<html>
    <head>
        <title>e-Barangay - <?php echo $res_val["resLname"] . ", " . $res_val["resFname"]; ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../global_assets/css/master.css">
        <link rel="stylesheet" href="../../global_assets/css/sign-up.css">
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
    <?php 
        if($is_admn_lgn) {
            ?>
                <div class = "uid">
                    <span><?php echo "@" . $admn_uid; ?></span>
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
                <a href="home"> H O M E </a>
                <a href="about"> A B O U T </a>
                <a href="guide"> U S E R - G U I D E </a>
    <?php 
        if($is_admn_lgn) {
            ?>
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
            <?php 
        } else {
            ?>
                <a href="login"> L O G I N / S I G N U P </a>
            <?php
        }        
    ?>
            </div>  
        </div>
    <!-- /Navigation Bar/ -->
    <!-- Content -->
        <form id = "frmAcc" method = "POST" action = "controllers/acc/create-account" enctype="multipart/form-data">
            <div class = "content">
                <div class = "create-account">
                    <div class = "push-left">
                        <span class = "request-title"> Brgy Residents</span>
                    </div>
                    <table class = "grid">
                        <tr>
                            <td class = "cell-pic">
                                <img class = "img-button profile-pic" src="../../file/load/img?type=view1&r_id=<?php echo $hash_id?>" id = "uploaded_dp">
                            </td>
                            <td class = "cell-info">
                                <table class = "main-grid">
                                    <tr>
                                        <td>
                                            <span class = "sys-label">First Name</span>
                                            <input class = "sys-text" name = "Fname" minlength = "2" maxlength = "25" value = "<?php echo $res_val["resFname"]; ?>" readonly>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Middle Name</span>
                                            <input class = "sys-text" name = "Mname" maxlength = "25" value = "<?php echo $res_val["resMname"]; ?>" readonly>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Last Name</span>
                                            <input class = "sys-text" name = "Lname" minlength = "2" value = "<?php echo $res_val["resLname"]; ?>" maxlength = "25" readonly>
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Suffix</span>
                                            <input class = "sys-text" name = "Suffix" maxlength = "5" value = "<?php echo $res_val["resSuffix"]; ?>" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class = "sys-label">Civil Status</span>
                                            <input class = "sys-text" name = "CivStat" value = "<?php echo getCivilStatus($res_val["resCivStat"]); ?>" readonly>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Citizenship</span>
                                            <input class = "sys-text" name = "Ctznshp" min = "2" maxlength = "25" value = "<?php echo $res_val["resCitiznshp"]; ?>" readonly>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Birthdate <span class = "sys-label sub-lbl">(Month, Day, Year)</span></span>
                                            <input type = "date" class = "sys-text" name = "Bdate" value = "<?php echo $res_val["resBdate"]; ?>" readonly>
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Sex</span>
                                            <input class = "sys-text" name = "Sex" value = "<?php echo $res_val["resSex"]; ?>" readonly>
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
                                            <span class = "sys-label">Address <span class = "sys-label sub-lbl">(House Number, Street Name, Barangay, Zone, City)</span></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class = "col-sm">
                                            <input class = "sys-text" name = "HouseNum" maxlength = "25" value = "<?php echo $res_val["resHouseNum"]; ?>" readonly>
                                        </td>
                                        <td>
                                            <input class = "sys-text" name = "StName" value = "<?php echo $res_val["resStName"]; ?>" readonly>
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
                                            <span class = "sys-label">Contact Number</span>
                                            <input class = "sys-text" name = "Contact" maxlength = "25" value = "<?php echo $res_val["resContact"]; ?>" readonly>
                                            <span class = "validate-msg" id = "cntct-msg"></span>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Email Address</span>
                                            <input type = "email" class = "sys-text" name = "Email" maxlength = "25" value = "<?php echo $res_val["resEmail"]; ?>" readonly>
                                            <span class = "validate-msg" id = "email-msg"></span>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Facebook Name</span>
                                            <input class = "sys-text" name = "FbName" maxlength = "25" value = "<?php echo $res_val["resFbName"]; ?>" readonly>
                                        </td>
                                        <td>
                                            <span class = "sys-label"><em>Registered Voter?</em></span>
                                            <input class = "sys-text" name = "Voter" maxlength = "25" value = "<?php echo $res_val["resVoter"]; ?>" readonly>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td colspan = "4"><span class = "sys-label row-title">Attachments</span></td>
                        </tr>
                        <tr>
                            <td> 
                                <input type = "checkbox"  id = "chck_idcard" disabled checked>
                                <label for = "chck_idcard" class = "sys-chck-label">ID (Front and Back)</label>
                            </td>
                            <td> 
                                <input type = "checkbox" id = "chck_selfie" disabled checked>
                                <label for = "chck_selfie" class = "sys-chck-label">Selfie</label>
                            </td>
                            <td> 
                                <input type = "checkbox" id = "chck_sig" disabled checked>
                                <label for = "chck_sig" class = "sys-chck-label">3 Specimen Signature</label>
                            </td>
                        </tr>
                    </table>
                    
                    <input class = "sys-button button-2" onclick = "location.href='barangay-profile'" value = "Back">
                    <input type = "button" class = "sys-button" onclick = "location.href='../controllers/service/del-res?res_id=<?php echo $res_id; ?>'"  value = "Remove">
                </div>
            </div>
        </form>
    <!-- /Content/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../global_assets/js/datetime.js"></script>
    <script src="../global_assets/js/sign-up.js"></script>

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