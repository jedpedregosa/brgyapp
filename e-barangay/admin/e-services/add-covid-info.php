<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }

    $is_err = false;
    if(isset($_SESSION["cov_req_status"])) {
        unset($_SESSION["cov_req_status"]);
        $is_err = true;
    }
?>

<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../global_assets/css/master.css">
        <link rel="stylesheet" href="../assets/css/donation.css">
        
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
        </div>
    <!-- /Navigation Bar/ -->
    <!-- Content -->
        <form id = "frmCovidInfo" method = "POST" action = "../controllers/service/submit-covid-info" enctype="multipart/form-data">
            <div class = "content">
                <div class = "create-donation">
                    <h3 class = "title">C O V I D - 1 9 &nbsp; I N F O R M A T I O N</h3>
                    <table class = "grid">
                        <tr>
                            <td>
                                <span class = "sys-label">First Name</span>
                                <input class = "sys-text" name = "firstname" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Middle Name</span>
                                <input class = "sys-text" name = "middlename" maxlength = "25">
                            </td>
                            <td>
                                <span class = "sys-label">Last Name</span>
                                <input class = "sys-text" name = "lastname" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Suffix</span>
                                <input class = "sys-text" name = "suffix" maxlength = "5">
                            </td>
                            <td>
                                <span class = "sys-label">Type of Covid</span>
                                <select class = "sys-text" name = "covtype" id = "slct_cov" required>
                                    <option value = "" selected disabled>- choose -</option>
                                    <option value = "Symptomatic"> Symptomatic</option>
                                    <option value = "Asymptomatic"> Asymptomatic</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class = "sys-label">Contact Number</span>
                                <input class = "sys-text" name = "contact" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Email Address</span>
                                <input class = "sys-text" type = "email" name = "email" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Citizenship</span>
                                <input class = "sys-text" name = "citizenship" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Age</span>
                                <input class = "sys-text" name = "age" maxlength = "3" required>
                            </td>
                            <td>
                                <span class = "sys-label">Sex</span>
                                <select class = "sys-text" name = "sex" required>
                                    <option value = "M" selected>Male</option>
                                    <option value = "F" selected>Female</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <table class = "main-grid">
                        <tr>
                            <td colspan = "5">
                                <span class = "sys-label">Address <span class = "sys-label sub-lbl">(House Number, Street Name, Barangay, Zone, City)</span></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class = "sys-text" name = "hnum" placeholder = "House No" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <select class = "sys-text" name = "stname" required>
                                    <option value = "Tengco"> Tengco</option>
                                    <option value = "Aurora"> Aurora</option>
                                    <option value = "Arnaiz"> Arnaiz</option>
                                    <option value = "Tramo"> Tramo</option>
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
                    <div id = "symp-div">
                        <table class = "main-grid">
                            <tr>
                                <td>
                                    <span class = "sys-label">Date Admitted</span>
                                    <input type = "date" class = "sys-text" name = "admitted">
                                </td>
                                <td>
                                    <span class = "sys-label">Date Discharged</span>
                                    <input type = "date" class = "sys-text" name = "discharge">
                                </td>
                                <td>
                                    <span class = "sys-label">Start date (Quarantine)</span>
                                    <input type = "date" class = "sys-text" name = "start">
                                </td>
                                <td>
                                    <span class = "sys-label">End date (Quarantine)</span>
                                    <input type = "date" class = "sys-text" name = "end">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id = "asymp-div">
                        <table class = "main-grid">
                            <tr>
                                <td>
                                    <span class = "sys-label">Start date (Quarantine)</span>
                                    <input type = "date" class = "sys-text" name = "s_start">
                                </td>
                                <td>
                                    <span class = "sys-label">End date (Quarantine)</span>
                                    <input type = "date" class = "sys-text" name = "s_end">
                                </td>
                                <td colspan = "2"></td>
                            </tr>
                        </table>
                    </div>
                    <input class = "sys-button button-2" onclick = "location.href='covid-info'" value = "C A N C E L">
                    <input class = "sys-button" type = "submit" value = "S U B M I T">
                </div>
            </div>
        </form>
        

<?php 
    if($is_err) {
            ?>
            
            <div id = "response_msg" class = "modal modal-alert">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick = "document.getElementById('response_msg').style.display = 'none';">&times;</span>
                    <p class = "modal-header header-lg error">Submit Information Unsuccessful</p>
                    <p class = "modal-sub-header header-lg">There is a problem while processing your request, please try again.</p>
                </div>
            </div>

            <?php
    }
?>
    <!-- /Content/ --> 
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../../global_assets/js/datetime.js"></script>
    <script src="../assets/js/add-info.js"></script>

<?php 
    if($is_err) {
        ?>
            <script>document.getElementById("response_msg").style.display = "block";</script>
        <?php
    }
?>
</html>