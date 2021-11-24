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

    $hasData = false;
    $res_val = [];
    if(isset($_GET["r_id"])) {
        $res_id = $_GET["r_id"];

        $req_sql = "SELECT res.*, TIMESTAMPDIFF(YEAR, res.resBdate, CURDATE()) AS age FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE res.resUname = ?";
        $resident_data = selectStatement("f", $req_sql, [$res_id]);

        if($resident_data["req_result"]) {
            if($resident_data["req_val"]) {
                $res_val = $resident_data["req_val"];
                $hasData = true;
            } 
        }
    }
?>

<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../global_assets/css/master.css">
        <link rel="stylesheet" href="../assets/css/donation.css">
        <link rel="stylesheet" href="../assets/css/add-info.css">
        
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
        </div>
    <!-- /Navigation Bar/ -->
    <!-- Content -->
        <form id = "frmCovidInfo" method = "POST" action = "../controllers/service/submit-covid-info" enctype="multipart/form-data">
            <div class = "content">
                <div class = "create-donation">
                    <h3 class = "title">C O V I D - 1 9 &nbsp; I N F O R M A T I O N</h3>
                    <div class = "col-right">
                        <div>
                            <input class = "search-field" placeholder = "Search Residents..." id = "txtSearch"/>
                            <div class = "dropdown-content" id = "search-content">
                            </div>
                        </div>
                    </div>
                    <table class = "grid">
                        <tr>
                            <td>
                                <span class = "sys-label">First Name</span>
                                <input class = "sys-text" value = "<?php echo ($hasData) ? $res_val["resFname"] : ""; ?>" name = "firstname" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Middle Name</span>
                                <input class = "sys-text" value = "<?php echo ($hasData) ? $res_val["resMname"] : ""; ?>" name = "middlename" maxlength = "25">
                            </td>
                            <td>
                                <span class = "sys-label">Last Name</span>
                                <input class = "sys-text" name = "lastname" value = "<?php echo ($hasData) ? $res_val["resLname"] : ""; ?>" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Suffix</span>
                                <input class = "sys-text" name = "suffix" value = "<?php echo ($hasData) ? $res_val["resSuffix"] : ""; ?>" maxlength = "5">
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
                                <input class = "sys-text" name = "contact" value = "<?php echo ($hasData) ? $res_val["resContact"] : ""; ?>" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Email Address</span>
                                <input class = "sys-text" type = "email" name = "email" value = "<?php echo ($hasData) ? $res_val["resEmail"] : ""; ?>" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Citizenship</span>
                                <input class = "sys-text" name = "citizenship" value = "<?php echo ($hasData) ? $res_val["resCitiznshp"] : ""; ?>" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Age</span>
                                <input class = "sys-text" name = "age" maxlength = "3" value = "<?php echo ($hasData) ? $res_val["age"] : ""; ?>" required>
                            </td>
                            <td>
                                <span class = "sys-label">Sex</span>
                                <select class = "sys-text" name = "sex" required>
                                    <option value = "M" <?php echo ($hasData && $res_val["resSex"] == 'M') ? "selected": (!$hasData) ? "selected": ""; ?>>Male</option>
                                    <option value = "F" <?php echo ($hasData && $res_val["resSex"] == 'F') ? "selected" : ""; ?>>Female</option>
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
                                <input class = "sys-text" name = "hnum" placeholder = "House No" value = "<?php echo ($hasData) ? $res_val["resHouseNum"] : ""; ?>" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <select class = "sys-text" name = "stname" required>
                                    <option value = "Tengco" <?php echo ($hasData && $res_val["resStName"] == 'Tengco' || !$hasData) ? "selected": ""; ?>> Tengco</option>
                                    <option value = "Aurora" <?php echo ($hasData && $res_val["resStName"] == 'Aurora') ? "selected": ""; ?>> Aurora</option>
                                    <option value = "Arnaiz" <?php echo ($hasData && $res_val["resStName"] == 'Arnaiz') ? "selected": ""; ?>> Arnaiz</option>
                                    <option value = "Tramo" <?php echo ($hasData && $res_val["resStName"] == 'Tramo') ? "selected": ""; ?>> Tramo</option>
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
                            <tr>
                                <td colspan = "4">
                                    <span class = "sys-label">Symptoms <span class = "sys-label sub-lbl">(Check the box)</span></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan = "4">
                                    <table class = "main-grid">
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Fever"> Fever
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Sore Throat"> Sore Throat
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Aches and pains"> Aches and pains
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Chest pain or pressure"> Chest pain or pressure
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Dry Cough"> Dry Cough
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Diarrhoea"> Diarrhoea
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Loss of taste or smell"> Loss of taste or smell
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Loss of speech or movement"> Loss of speech or movement
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Tiredness"> Tiredness
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Conjunctivitis"> Conjunctivitis
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Rash on skin"> Rash on skin
                                                </label>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Headache"> Headache
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Discolouration of fingers or toes"> Discolouration of fingers or toes
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type = "checkbox" name = "symptoms[]" value = "Difficulty breathing or shortness of breath"> Difficulty breathing or shortness of breath
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan = "4">
                                                <span class = "sys-label"><em>Hospital Admitted</em></span>
                                                <textarea class = "sys-text" name = "hospital"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan = "4">
                                                <span class = "sys-label"><em>Last Contacts</em> <span class = "sys-label sub-lbl">(Input fullname, relation, contact details)</span></span>
                                                <textarea class = "sys-text" name = "s_last_contact"></textarea>
                                            </td>
                                        </tr>
                                    </table>
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
                            <tr>
                                <td colspan = "4">
                                    <span class = "sys-label"><em>Last Place you've been</em></span>
                                    <textarea class = "sys-text" name = "last_place" placeholder = "Input Place"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan = "4">
                                    <span class = "sys-label"><em>Last Contacts</em> <span class = "sys-label sub-lbl">(Input fullname, relation, contact details)</span></span>
                                    <textarea class = "sys-text" name = "last_contact"></textarea>
                                </td>
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