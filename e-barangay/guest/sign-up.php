<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");

    $isSubmit = false;
    $isCreate_success = false;

    if(isset($_SESSION["req_response_type"])) {
        $result = $_SESSION["req_response_type"];
        if($result == 100) {
            $isSubmit = true;
            $isCreate_success = true;
        } else if($result == 101) {
            $isSubmit = true;
            $isCreate_success = false;
        }

        unset($_SESSION["req_response_type"]);
    }
?>
<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../global_assets/css/master.css">
        <link rel="stylesheet" href="../global_assets/css/sign-up.css">
        
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
                <a href="login"> L O G I N / S I G N U P </a>
            </div>  
        </div>
    <!-- /Navigation Bar/ -->
    <!-- Content -->
        <form id = "frmAcc" method = "POST" action = "controllers/acc/create-account" enctype="multipart/form-data">
            <div class = "content">
                <div class = "create-account">
                    <h3 class = "title">CREATE AN ACCOUNT</h3>
                    <table class = "grid">
                        <tr>
                            <td class = "cell-pic">
                                <img class = "img-button profile-pic" onclick="document.getElementById('upload_dp').click();" src="../global_assets/img/blank-profile.png" id = "uploaded_dp">
                                <input type = "file" class = "hidden-upload" id = "upload_dp" name = "profilePic" onchange = "checkDpUpload()" accept=".jpg,.png">
                                <span class = "validate-msg" id = "dp-upload-msg"></span>
                            </td>
                            <td class = "cell-info">
                                <table class = "main-grid">
                                    <tr>
                                        <td>
                                            <span class = "sys-label">First Name</span>
                                            <input class = "sys-text" name = "Fname" minlength = "2" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Middle Name</span>
                                            <input class = "sys-text" name = "Mname" minlength = "2" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Last Name</span>
                                            <input class = "sys-text" name = "Lname" minlength = "2" maxlength = "25" required>
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Suffix</span>
                                            <input class = "sys-text" name = "Suffix" maxlength = "5">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class = "sys-label">Civil Status</span>
                                            <select class = "sys-text" name = "CivStat" required>
                                                <option value = "1"> Single</option>
                                                <option value = "2"> Married</option>
                                                <option value = "3"> Divorced</option>
                                                <option value = "4"> Separated</option>
                                                <option value = "5"> Widowed</option>
                                            </select>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Citizenship</span>
                                            <input class = "sys-text" name = "Ctznshp" min = "2" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Birthdate <span class = "sys-label sub-lbl">(Month, Day, Year)</span></span>
                                            <input type = "date" class = "sys-text" name = "Bdate" required>
                                        </td>
                                        <td class = "col-sm">
                                            <span class = "sys-label">Sex</span>
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
                                            <span class = "sys-label">Address <span class = "sys-label sub-lbl">(House Number, Street Name, Barangay, Zone, City)</span></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class = "col-sm">
                                            <input class = "sys-text" name = "HouseNum" maxlength = "25" required>
                                        </td>
                                        <td>
                                            <select class = "sys-text" name = "StName" required>
                                                <option value = "Tengco"> Tengco</option>
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
                                            <span class = "sys-label">Contact Number</span>
                                            <input class = "sys-text" name = "Contact" maxlength = "25" onchange = "validateUsername(this.value, 'a')" required>
                                            <span class = "validate-msg" id = "cntct-msg"></span>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Email Address</span>
                                            <input type = "email" class = "sys-text" name = "Email" maxlength = "25" onchange = "validateUsername(this.value, 'c')" required>
                                            <span class = "validate-msg" id = "email-msg"></span>
                                        </td>
                                        <td>
                                            <span class = "sys-label">Facebook Name</span>
                                            <input class = "sys-text" name = "FbName" maxlength = "25">
                                        </td>
                                        <td>
                                            <span class = "sys-label"><em>Registered Voter?</em></span>
                                            <input class = "sys-text" name = "Voter" maxlength = "25">
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
                                <input type = "button" id = "upload_button"  onclick = "uploadClick()">
                                <input type = "file" id = "upload_idcard" class ="hidden-upload" name = "idCardPic" onchange = "checkUpload(this)" accept=".jpg,.png">
                                <input type = "file" id = "upload_selfie" class ="hidden-upload" name = "selfiePic" onchange = "checkUpload(this)" accept=".jpg,.png">
                                <input type = "file" id = "upload_sig" class ="hidden-upload" name = "sigPic" onchange = "checkUpload(this)" accept=".jpg,.png">
                            </td>
                            <td> 
                                <input type = "checkbox"  id = "chck_idcard" onchange = "renderChecklist()" disabled>
                                <label for = "chck_idcard" class = "sys-chck-label">ID (Front and Back)</label>
                            </td>
                            <td> 
                                <input type = "checkbox" id = "chck_selfie" onchange = "renderChecklist()" disabled>
                                <label for = "chck_selfie" class = "sys-chck-label">Selfie</label>
                            </td>
                            <td> 
                                <input type = "checkbox" id = "chck_sig" onchange = "renderChecklist()" disabled>
                                <label for = "chck_sig" class = "sys-chck-label">3 Specimen Signature</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "4">
                                <span class = "validate-msg" id = "file-upload-msg"></span>
                                <span class = "sys-label sub-lbl">(Please submit all requirements needed. Inclomplete requirements will be automatically rejected)</span>
                            </td>
                        </tr>
                    </table>
                    
                    <input class = "sys-button button-2" onclick = "location.href='login'" value = "C A N C E L">
                    <input type = "button" class = "sys-button" onclick = "submitAccount()" value = "S I G N  U P">
                </div>
            </div>
            <div id="assign_password" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <table class = "main-grid">
                        <tr>
                            <td colspan = "2">
                                <p class = "modal-header">Setup username and password</p>
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class = "sys-label">New Username:</span>
                                <input class = "sys-text" id = "txtUsername" name = "Uname" minlength = "7" maxlength = "15"  onchange = "validateUsername(this.value, 'b')" required>
                                <span class = "sys-label">Re-enter Username:</span>
                                <input class = "sys-text" id = "txtConUsername" minlength = "7" maxlength = "15" onkeyup = "isUsernameValidated()" required>
                                <span class = "validate-msg" id = "uname-msg"></span>
                            </td>
                            <td>
                                <span class = "sys-label">New Password:</span>
                                <input type = "password" class = "sys-text" id = "txtPassword" name = "Pword" minlength = "8" maxlength = "15" required>
                                <span class = "sys-label">Re-enter Password:</span>
                                <input type = "password" class = "sys-text" id = "txtConPassword" minlength = "8" maxlength = "15" onkeyup = "isPasswordValidated()" required>
                                <span class = "validate-msg" id = "password-msg"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2" class = "cell-right">
                                <input type = "button" class = "sys-modal-button modal-button-2" onclick = "closeModal('assign_password')" value = "Cancel">
                                <input type = "button" class = "sys-modal-button" onclick = "submitForm()" value = "Save">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
<?php 
    if($isSubmit) {
        if($isCreate_success) {
            ?>
            
            <div id = "response_msg" class = "modal modal-alert">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick = "location.href = 'login'">&times;</span>
                    <p class = "modal-header header-lg">Request succesfully sent!</p>
                    <p class = "modal-sub-header header-lg">Please wait for a maximum of 2 days to verify and confirm your account.</p>
                </div>
            </div>

            <?php
        } else {
            ?>
            
            <div id = "response_msg" class = "modal modal-alert">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick = "closeModal('response_msg')">&times;</span>
                    <p class = "modal-header header-lg error">Create Account Unsuccessful</p>
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