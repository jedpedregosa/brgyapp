<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");
    
    if(!$is_resdnt_lgn) {
        header("Location: ../logout");
        exit();    
    }

    $isSubmit = false;
    $isCreate_success = false;

    if(isset($_SESSION["report_response_type"])) {
        $result = $_SESSION["report_response_type"];
        if($result == 100) {
            $isSubmit = true;
            $isCreate_success = true;
        } else if($result == 101) {
            $isSubmit = true;
            $isCreate_success = false;
        }

        unset($_SESSION["report_response_type"]);
    }
?>
<html>
    <head>
        <title>e-Barangay - Blotter Report</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../global_assets/css/master.css">
        <link rel="stylesheet" href="../../global_assets/css/sign-up.css">
        
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
        <form id = "frmBlotter" method = "POST" action = "../controllers/service/submit-blotter-report" enctype="multipart/form-data">
            <div class = "content">
                <div class = "create-account">
                    <h3 class = "title">Incident Report Form</h3>
                    <table class = "main-grid">
                        <tr>
                            <td colspan = "2">
                                <span class = "required-msg">* REQUIRED FIELDS</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2">
                                <span><strong>Complainant Information</strong></span>
                            </td>
                        </tr>
                        <tr>
                            <td class = "cell-info" colspan = "2">
                                <table class = "main-grid">
                                    <tr>
                                        <td>
                                            <span class = "sys-label">First Name <span class = "required">*</span></span>
                                            <input class = "sys-text" name = "firstname" minlength = "2" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Last Name <span class = "required">*</span></span>
                                            <input class = "sys-text" name = "lastname" minlength = "2" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Alias</span>
                                            <input class = "sys-text" name = "alias" maxlength = "25">
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Suffix</span>
                                            <input class = "sys-text" name = "suffix" maxlength = "5">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class = "sys-label">Contact Number <span class = "required">*</span></span>
                                            <input class = "sys-text" name = "contact" min = "2" maxlength = "11" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Email Address <span class = "required">*</span></span>
                                            <input type = "email" class = "sys-text" name = "email" min = "2" maxlength = "50" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Citizenship <span class = "required">*</span></span>
                                            <input class = "sys-text" name = "ctzn" min = "2" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Age <span class = "required">*</span></span>
                                            <input class = "sys-text" name = "age" maxlength = "3" required>
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Sex <span class = "required">*</span></span>
                                            <select class = "sys-text" name = "Sex" required>
                                                <option value = "M" selected>M</option>
                                                <option value = "F" selected>F</option>
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
                                            <span class = "sys-label">Address <span class = "sys-label sub-lbl">(House Number, Street Name, Barangay, Zone, City)</span> <span class = "required">*</span></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class = "col-sm">
                                            <input class = "sys-text" name = "HouseNum" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <select class = "sys-text" name = "street" required>
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
                                <table class = "main-grid">
                                    <tr>
                                        <td>
                                            <span class = "sys-label">Date of Incident (M/D/Y) <span class = "required">*</span></span>
                                            <input type = "date" class = "sys-text" name = "dateoc" required>
                                        </td>
                                        <td colspan = "2">
                                            <span class = "sys-label">Incident take place <span class = "required">*</span></span>
                                            <textarea class = "sys-text" name = "incident" required></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table class = "main-grid">
                        <tr>
                            <td colspan = "2">
                                <span><strong>Defendant Information</strong></span>
                            </td>
                        </tr>
                        <tr>
                            <td class = "cell-info" colspan = "2">
                                <table class = "main-grid">
                                    <tr>
                                        <td>
                                            <span class = "sys-label">First Name <span class = "required">*</span></span>
                                            <input class = "sys-text" name = "susfirstname" minlength = "2" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Last Name <span class = "required">*</span></span>
                                            <input class = "sys-text" name = "suslastname" minlength = "2" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Alias</span>
                                            <input class = "sys-text" name = "susalias" maxlength = "25">
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Suffix</span>
                                            <input class = "sys-text" name = "sussuffix" maxlength = "5">
                                        </td>
                                        <td>
                                            <span class = "sys-label">Age <span class = "required">*</span></span>
                                            <input class = "sys-text" name = "susage" maxlength = "3" required>
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Sex <span class = "required">*</span></span>
                                            <select class = "sys-text" name = "susSex" required>
                                                <option value = "M" selected>M</option>
                                                <option value = "F" selected>F</option>
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
                                            <span class = "sys-label">Address <span class = "sys-label sub-lbl">(House Number, Street Name, Barangay, Zone, City)</span> <span class = "required">*</span></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class = "col-sm">
                                            <input class = "sys-text" name = "susHouseNum" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <select class = "sys-text" name = "susstreet" required>
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
                                    <tr>
                                        <td colspan = "5">
                                            <span><strong>Reason for Reporting</strong> <span class = "required">*</span></span>
                                            <textarea class = "sys-text" name = "reason" required></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td colspan = "2"><span class = "sys-label row-title">Attachments</span></td>
                        </tr>
                        <tr>
                            <td>
                                <input type = "button" id = "upload_button" onclick = "document.getElementById('idfile').click()" value = "Upload File">
                                <input type = "file" class ="hidden-upload" id = "idfile" name = "idfile" accept=".jpg,.png">
                            </td>
                            <td>
                                <label class = "sys-chck-label">
                                    <input type = "checkbox" id = "chckup" disabled/> Valid ID
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2">
                                <span class = "validate-msg" id = "file-upload-msg"></span>
                            </td>
                        </tr>
                    </table>

                    <input class = "sys-button button-2" onclick = "location.href='login'" value = "C A N C E L">
                    <input type = "button" class = "sys-button" onclick = "submitAccount()" value = "S U B M I T">
                </div>
            </div>

<?php 
    if($isSubmit) {
        if($isCreate_success) {
            ?>
            
            <div id = "response_msg" class = "modal modal-alert">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick = "location.href = '../home'">&times;</span>
                    <p class = "modal-sub-header header-lg">The report has been submitted.</p>
                    <p class = "modal-sub-header header-lg"><?php echo getTimeDate("(F. d, Y - h:m a)");?></p>
                    <p class = "modal-sub-header header-lg">Please wait for it to be reviewed. Kindly check your email for updates.</p>
                </div>
            </div>

            <?php
        } else {
            ?>
            
            <div id = "response_msg" class = "modal modal-alert">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick = "closeModal('response_msg')">&times;</span>
                    <p class = "modal-header header-lg error">Submitting Report Unsucessful</p>
                    <p class = "modal-sub-header header-lg">There is a problem while processing your request, please try again.</p>
                </div>
            </div>

            <?php
        }
    }
?>
        </form>
    <!-- /Content/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../../global_assets/js/datetime.js"></script>
    <script src="../../global_assets/js/file.js"></script>
    <script src="../assets/js/blotter-report.js"></script>

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