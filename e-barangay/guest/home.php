<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");

    // Check Login

    // Get Updates
    $all_posts = getAllPost();
    $all_health_upd = getAllHealthUpd();

    $covid_info = getAllCovidInfo();
?>
<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../global_assets/css/master.css">
        <link rel="stylesheet" href="../global_assets/css/home.css">
        
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
                        <a href="e-services/barangay-id-form">BARANGAY IDENTIFICATION (ID)</a>
                        <a href="e-services/barangay-indigency">BARANGAY INDIGENCY</a>
                        <a href="e-services/barangay-burial-cert">BURIAL CERTIFICATION</a>
                        <a href="e-services/barangay-employment-form">CERTIFICATE OF EMPLOYMENT</a>
                        <a href="e-services/barangay-travel-cert">CERTIFICATE TO TRAVEL</a>
                        <a href="e-services/barangay-proof-res">PROOF OF RESIDENCY</a>
                        <a href="e-services/barangay-blotter-report">BLOTTER REPORT</a>
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
    <!-- /Navigation Bar/ -->
    <!-- Content -->
        <div class = "content">
            <table style="width:100%">
                <tr>
                    <!-- COVID UPDATES -->
                    <td>
                        <div class="ex1">
                            <h1 class = "card-title">COVID-19 Updates</h1>
                            <span class = "card-info">Data based on cases reported with official results and verified to be Barangay 108, Zone 12 residents.</span>
                            <span class = "card-header">As of <?php echo getTimeDate("F d, Y (l)"); ?></span>
                            <span class = "card-header">From Department of Health</span>

                            <table class = "card-grid">
                                <tr>
                                    <td>
                                        <div class = "card-covid">
                                            <div class = "card-covid-content">
                                                <span class = "card-sub">TOTAL</span>
                                                <span class = "card-val"><?php echo ($covid_info) ? (int)$covid_info["total"] : "Error";?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class = "card-covid">
                                            <div class = "card-covid-content">
                                                <span class = "card-sub">
                                                    <span class = "text-error">ACTIVE</span>
                                                </span>
                                                <span class = "card-val"><?php echo ($covid_info) ? (int)$covid_info["active"] : "Error";?></span>
                                            </div>  
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class = "card-covid">
                                            <div class = "card-covid-content">
                                                <span class = "card-sub">
                                                    <span class = "text-success">RECOVERED</span>
                                                </span>
                                                <span class = "card-val"><?php echo ($covid_info) ? (int)$covid_info["recovered"] : "Error";?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class = "card-covid">
                                            <div class = "card-covid-content">
                                                <span class = "card-sub">
                                                    <span class = "text-info">DEATH</span>
                                                </span>
                                                <span class = "card-val"><?php echo ($covid_info) ? (int)$covid_info["death"] : "Error";?></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <span class = "card-header">WE URGE YOU TO STAY AT HOME AND BE SAFE!</span>
                        </div>
                    </td>
                    <!-- SLIDESHOW -->
                    <td class = "cl-slideshow"> 
                        <div class="slideshow-container">
                            <div class="mySlides fade">
                                <img src="../global_assets/img/slideshows/slideshow-1.jpg" style="width:50%">
                            </div>
                            <div class="mySlides fade">
                                <img src="../global_assets/img/slideshows/slideshow-2.jpg" style="width:50%">
                            </div>
                            <div class="mySlides fade">
                                <img src="../global_assets/img/slideshows/slideshow-3.jpg" style="width:50%">
                            </div>
                            <div class="mySlides fade">
                                <img src="../global_assets/img/slideshows/slideshow-4.jpg" style="width:50%">
                            </div>
                            <div class="mySlides fade">
                                <img src="../global_assets/img/slideshows/slideshow-5.jpg" style="width:50%">
                            </div>
                            <br>
                            <div style="text-align:center">
                                <span class="dot"></span> 
                                <span class="dot"></span> 
                                <span class="dot"></span> 
                                <span class="dot"></span> 
                                <span class="dot"></span> 
                            </div>
                        </div>
                        <div class = "directories">
                            <span class = "card-header hotlines">HOTLINES</span>
                            <table class = "directories-content">
                                <tr>
                                    <td>
                                        <span class = "icon-phone">
                                            <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                        </span>
                                        <span class = "phone-title">Barangay 108</span>
                                        <span class = "phone-val">8511-1618</span>
                                    </td>
                                    <td>
                                        <span class = "icon-phone">
                                            <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                        </span>
                                        <span class = "phone-title">Pasay City Public Office</span>
                                        <span class = "phone-val">8831-6459</span>
                                    </td>
                                    <td>
                                        <span class = "icon-phone">
                                            <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                        </span>
                                        <span class = "phone-title">Pasay City General Hospital</span>
                                        <span class = "phone-val">8833-6022</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="ex2">
                            <h1 class = "card-title">ANNOUNCEMENTS</h1>
            <?php 
                if($all_posts) {
                    foreach((array)$all_posts as $post) {
                        $raw_date = new DateTime($post["sysTime"]);
                        $post_time = $raw_date->format("h:i a");
                        $post_date = $raw_date->format("M d, Y");

                        
                        ?>
                            <div class = "post-content">
                                <div class = "post-time">
                                    <span><?php echo $post_date; ?> | <?php echo $post_time; ?></span>
                                </div>
                                <div class = "post-msg">
                                    <?php echo $post["anncmntMsg"]; ?>
                        <?php 
                            if($post["anncmntHasPic"]) {
                                ?>
                                    <img class = "post-img" src = "../file/POST/post_photo?type=view1&p_id=<?php echo $post["anncmntId"];?>" onclick = "showImgModal(<?php echo $post['anncmntId'];?>, 1)" onerror = "this.style.display = 'none'"/>
                                <?php
                            }

                            if($post["anncmntHasFile"]) {
                                ?>
                                    <div class="info-msg" id = "uploaded_img">
                                        <i class="fa fa-file-pdf-o"></i> &ensp;
                                        <span class = "filename"><a href = "../file/POST/post_file?type=view1&p_id=<?php echo $post["anncmntId"];?>"><strong>Download</strong> <?php echo $post["anncmntFname"]; ?></a></span>
                                    </div>
                                <?php
                            }
                        ?>            
                                </div>
                            </div>
                        <?php
                    }
                    
                } else {
                    ?>
                        <div class = "post-content"><span>No Announcements found.</span></div>
                    <?php
                }
            ?>
                            
                        </div>
                    </td>
                    <td>	
                        <div class="ex2">
                            <h1 class = "card-title">HEALTH UPDATES</h1>
            <?php 
                if($all_health_upd) {
                    foreach((array)$all_health_upd as $post) {
                        $raw_date = new DateTime($post["sysTime"]);
                        $post_time = $raw_date->format("h:i a");
                        $post_date = $raw_date->format("M d, Y");

                        
                        ?>
                            <div class = "post-content">
                                <div class = "post-time">
                                    <span><?php echo $post_date; ?> | <?php echo $post_time; ?></span>
                                </div>
                                <div class = "post-msg">
                                    <?php echo $post["updateMsg"]; ?>
                        <?php 
                            if($post["updateHasPic"]) {
                                ?>
                                    <img class = "post-img" src = "../file/POST/post_photo?type=view2&p_id=<?php echo $post["updateId"];?>" onclick = "showImgModal(<?php echo $post['updateId'];?>, 2)" onerror = "this.style.display = 'none'"/>
                                <?php
                            }

                            if($post["updateHasFile"]) {
                                ?>
                                    <div class="info-msg" id = "uploaded_img">
                                        <i class="fa fa-file-pdf-o"></i> &ensp;
                                        <span class = "filename"><a href = "../file/POST/post_file?type=view2&p_id=<?php echo $post["updateId"];?>"><strong>Download</strong> <?php echo $post["updateFname"]; ?></a></span>
                                    </div>
                                <?php
                            }
                        ?>            
                                </div>
                            </div>
                        <?php
                    }
                    
                } else {
                    ?>
                        <div class = "post-content"><span>No Health Updates found.</span></div>
                    <?php
                }
            ?>
                        </div>
                    </td>
                </tr>
            </table>
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
        <div class = "donation-div">
            <input type = "button" class = "sys-button sys-button-lg" onclick = "location.href='donation'"value = "DONATION DRIVE">
        </div>
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    <!-- /Content/ -->
    <body>
    <script src="../global_assets/js/datetime.js"></script>
    <script src="../global_assets/js/home.js"></script>
</html>


 
