<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");
?>
<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../global_assets/css/master.css">
        <link rel="stylesheet" href="../global_assets/css/about.css">
        <link rel="stylesheet" href="../global_assets/css/guide.css">

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
        if($is_resdnt_lgn) {
            ?>
                <div class="dropdown">
                    <button class="dropbtn">E-SERVICES
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="e-services/barangay-clearance">BARANGAY CLEARANCE</a>
                        <a href="e-services/health-updates">BARANGAY IDENTIFICATION (ID)</a>
                        <a href="e-services/barangay-indigency">BARANGAY INDIGENCY</a>
                        <a href="e-services/barangay-burial-cert">BURIAL CERTIFICATION</a>
                        <a href="e-services/barangay-employment-form">CERTIFICATE OF EMPLOYMENT</a>
                        <a href="e-services/barangay-travel-cert">CERTIFICATE TO TRAVEL</a>
                        <a href="e-services/barangay-proof-res">PROOF OF RESIDENCY</a>
                        <a href="e-services/barangay-blotter-report">INCIDENT REPORT</a>
                        <a></a>
                        <a href="e-services/view-profile"><strong>PROFILE</strong></a>
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
        <div class = "content">
            <table class = "main-grid">
                <tr>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-1.png" onclick = "showImgModal(this.src, 0)">
                    </td>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-2.png" onclick = "showImgModal(this.src, 1)">
                    </td>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-3.png" onclick = "showImgModal(this.src, 2)">
                    </td>
                </tr>
                <tr>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-4.png" onclick = "showImgModal(this.src, 3)">
                    </td>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-5.png" onclick = "showImgModal(this.src, 4)">
                    </td>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-6.png" onclick = "showImgModal(this.src, 5)">
                    </td>
                </tr>
                <tr>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-7.png" onclick = "showImgModal(this.src, 6)">
                    </td>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-8.png" onclick = "showImgModal(this.src, 7)">
                    </td>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-9.png" onclick = "showImgModal(this.src, 8)">
                    </td>
                </tr>
                <tr>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-10.png" onclick = "showImgModal(this.src, 9)">
                    </td>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-11.png" onclick = "showImgModal(this.src, 10)">
                    </td>
                    <td>
                        <img class = "post-img" src = "../global_assets/img/guide/user-guide-12.png" onclick = "showImgModal(this.src, 11)">
                    </td>
                </tr>
            </table>
        </div>
        <!-- The Modal -->
        <div id="res_img_modal" class="img-modal">

            <!-- The Close Button -->
            <span class="img-close" id = "img-close">&times;</span>

            <table class = "img-modal-grid">
                <tr>
                    <td>
                        <span class = "next-button" id = "img-prev">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </span>
                    </td>
                    <td>
                        <!-- Modal Content (The Image) -->
                        <img class="img-modal-content" id="sample_photo">
                    </td>
                    <td>
                        <span class = "next-button" id = "img-next">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </span>
                    </td>
                </tr>
            </table>
            <!-- Modal Caption (Image Text) -->
            <div id="img_caption"></div>
        </div>
    <!-- /Navigation Bar/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../global_assets/js/datetime.js"></script>
    <script src="../global_assets/js/guide.js"></script>
</html>