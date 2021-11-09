<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    $current_time = getTimeDate("(F. d, Y - h:m a)");

    $isSubmit = false;
    $isDonate_success = false;

    if(isset($_SESSION["don_response_type"])) {
        $result = $_SESSION["don_response_type"];
        if($result == 100) {
            $isSubmit = true;
            $isDonate_success = true;
        } else if($result == 101) {
            $isSubmit = true;
            $isDonate_success = false;
        }

        unset($_SESSION["don_response_type"]);
    }
?>

<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../global_assets/css/master.css">
        <link rel="stylesheet" href="../global_assets/css/donation.css">
        
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
                <img src="../global_assets/img/LOGO BRGY 108.png" height="150px">
            </div>
            <div class="text">
                <h1 class = "head-title">e-Barangay</h1>
                <h4> <i class = "fa fa-map-marker"></i>&ensp;519 Tengco Street, Pasay City,<br>Metro Manila </h4>
            </div>
            <div class="logo1">
                <img src="../global_assets/img/facebook.png" height="50px">
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
                        <a href="e-services/announcements">ANNOUNCEMENTS</a>
                        <a href="e-services/health-updates">HEALTH UPDATES</a>
                        <a href="e-services/covid-info">COVID-19 INFORMATION</a>
                        <a href="e-services/barangay-clearance">REQUESTS</a>
                        <a href="e-services/blotter-report">BLOTTER REPORTS</a>
                        <a href="e-services/charity-donation">DONATIONS</a>
                        <a href="">PROFILES</a>
                        <a href="logout">LOG OUT</a>
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
        <form id = "frmDonation" method = "POST" action = "controllers/service/submit-donation" enctype="multipart/form-data">
            <div class = "content">
                <div class = "create-donation">
                    <h3 class = "title">DONATION FORM</h3>
                    <table class = "grid">
                        <tr>
                            <td>
                                <span class = "sys-label">P O S I T I O N</span>
                                <input class = "sys-text" name = "txtPosition" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">LAST NAME</span>
                                <input class = "sys-text" name = "txtLname" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">First Name</span>
                                <input class = "sys-text" name = "txtFname" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Middle Initial</span>
                                <input class = "sys-text" name = "txtMi" maxlength = "25">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class = "sys-label">Email Address</span>
                                <input class = "sys-text" type = "email" name = "txtEmail" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <span class = "sys-label">Contact Number</span>
                                <input class = "sys-text" name = "txtContact" minlength = "2" maxlength = "25" required>
                            </td>
                            <td colspan = "2"></td>
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
                                <input class = "sys-text" name = "txtHnum" placeholder = "House No" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <input class = "sys-text" name = "txtStName" placeholder = "Street Name" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <input class = "sys-text" name = "txtBrgy" placeholder = "Barangay" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <input class = "sys-text" name = "txtCity" placeholder = "City" minlength = "2" maxlength = "25" required>
                            </td>
                            <td>
                                <input class = "sys-text" name = "txtPcode" placeholder = "Postal Code" minlength = "2" maxlength = "25" required>
                            </td>
                        </tr>
                        <tr>
                            <td class = "type-row">
                                <select class = "sys-text" name = "txtType" id = "slct_donation" required>
                                    <option selected disabled>Type of Donation</option>
                                    <option value = "dntn1"> In-kind</option>
                                    <option value = "dntn2"> Charity</option>
                                </select>
                            </td>
                            <td colspan = "4" class = "type-row">
                                <span id = "charity-div1"> N U M B E R : 123-456-789 / 123-456-789</span>
                            </td>
                        </tr>
                    </table>
                    <div id = "kind-div">
                        <table class = "main-grid">
                            <tr>
                                <td>
                                    <span class = "sys-label type2">Date of delivery</span>
                                    <input type = "date" class = "sys-text" name = "txtDate">
                                </td>
                                <td>
                                    <span class = "sys-label type2">Type of Goods and How many</span>
                                    <textarea class = "sys-text" name = "txtTypeG"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id = "charity-div2">
                        <table class = "main-grid">
                            <tr>
                                <td>
                                    <span class = "sys-label type2">Date of transactions</span>
                                    <input type = "date" class = "sys-text" name = "txtDateTrans">
                                </td>
                                <td>
                                    <span class = "sys-label type2">Type of Payment</span>
                                    <select class = "sys-text" name = "txtTypeP">
                                        <option selected disabled></option>
                                        <option value = "GCash"> GCash</option>
                                        <option value = "Bank"> Bank Transfer</option>
                                        <option value = "PayMaya"> PayMaya</option>
                                    </select>
                                </td>
                                <td>
                                    <span class = "sys-label type2">Amount</span>
                                    <input class = "sys-text" name = "txtAmount">
                                </td>
                                <td>
                                    <span class = "sys-label type2">Remarks</span>
                                    <textarea class = "sys-text" name = "txtRemark"></textarea>
                                </td>
                            </tr>
                        </table>
                        <span class = "sys-label type2 lbl-upload">Proof of Payment:</span>
                        <input type = "button" class = "button-3" id = "btn_upload" onclick = "document.getElementById('filePay').click();" value = "Upload Photo">
                        <span class = "validate-msg" id = "don-upload-msg"></span>
                        <input type = "file" class = "hidden-upload" name = "filePay" id = "filePay" onchange = "checkUpload()" accept=".jpg,.png">
                    </div>
                    <input class = "sys-button button-2" onclick = "location.href='home'" value = "C A N C E L">
                    <input class = "sys-button" onclick = "submitForm()" value = "S U B M I T">
                </div>
            </div>
        </form>
        

<?php 
    if($isSubmit) {
        if($isDonate_success) {
            ?>
            
        <div id = "response_msg" class = "modal modal-alert">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close" onclick = "location.href = 'home'">&times;</span>
                <span class = "modal-header header-lg">THANK YOU.</span>
                <span class = "modal-sub-header header-lg">Donation has been submitted.</span>
                <span class = "modal-sub-header header-lg"><?php echo $current_time; ?></span>
                <span class = "modal-sub-header header-lg">Please wait for Barangay to review and confirm your donation.</span>
                <span class = "modal-sub-header header-lg">Kindly check your email for updates.</span>
            </div>
        </div>

            <?php
        } else {
            ?>
            
            <div id = "response_msg" class = "modal modal-alert">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick = "document.getElementById('response_msg').style.display = 'none';">&times;</span>
                    <p class = "modal-header header-lg error">Submit Donation Unsuccessful</p>
                    <p class = "modal-sub-header header-lg">There is a problem while processing your request, please try again.</p>
                </div>
            </div>

            <?php
        }
    }
?>
    <!-- /Content/ --> 
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../global_assets/js/datetime.js"></script>
    <script src="../global_assets/js/donation.js"></script>

<?php 
    if($isSubmit) {
        ?>
            <script>document.getElementById("response_msg").style.display = "block";</script>
        <?php
    }
?>
</html>