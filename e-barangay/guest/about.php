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
                        <a href="">CERTIFICATE TO TRAVEL</a>
                        <a href="">PROOF OF RESIDENCY</a>
                        <a href="">BLOTTER REPORT</a>
                        <a></a>
                        <a href=""><strong>PROFILE</strong></a>
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
            <table class = "card-grid">
                <tr>
                    <td>
                        <div class = "card-history">
                            <div class = "card-history-content">
                                <h1 class = "card-history-title">History of Barangay 108 Zone 12</h1>
                                <span class = "card-history-text">
                                        During the first Barangay election which happened on May 17, 1982, Kapitan Isla was hailed as the first ever Barangay Captain of Brgy. 108. His reign lasted 8 years when Kapitan Alfredo R. Jondes took the responsibility of the positions. Jondes' governance lasted for 10 years, occupying a total of 3 electoral terms. He was then replaced by lan P. Vendivel during the 2002 Barangay Elections, which took place on the 15th of July of the said year. Vendivel's reign as Barangay Captain only lasted for approximately a year because of his candidacy as City Councilor. Because of this, the First Kagawad of that time, Marcos A. Ereña, replaced Vendivel as the new Barangay Captain. Ereña finished the remaining years of governance up until 2006.

                                        However, lan P. Vendivel is the first ever Barangay 108 Captain who became a City Councilor for 2nd district of Pasay. The 2007 elections happened and a new Brgy. Captain was elected which is Eugenio Marnelego. His governance lasted for only a term until 2010. In 2010, former appointed Brgy. Captain Marcos A. Ereña succeeded in running for the position. He has been serving as the Barangay 108 Captain from 2010 until the present time.

                                        Barangay 108 Zone 12 is located at Santa Clara area under District II legislative jurisdiction of Pasay City. It is composed of 500 estimated families with an estimated population of 2100. Barangay 108 bounded on the east by Aurora Street (Barangay 121 & 120), west by Tramo Street (Barangay 107), North by Antornio Amaiz Avenue (Fommer Cementina Street Barangay 66) and South by Tengco Street (Barangay 109).

                                        Barangay 108 is proud to have our territorial area of jurisdiction of 2.82 Hectares and is surrounded by many busy commercial establishments such as Card Bank Inc, Andok's, Capitol Restaurant and Ramesh Trading Corporation, LBC CARGO Services, Ochoa Pawnshop, Palawan Express and many more offices and Stores.

                                        This small barangay community proud to be the home of middle-class families having most of their income from varying public and private employments, smalls scale business enterprises and professional practices and skills.

                                        Among the various projects offered to our barangay constituents are decloging of canal, beautification of environment, clean-up and green campaign, programang pang edukasyon-distribution of school supplies, project and equipment for disaster preparedness preservation of peace and order of the community, anti-drug program and campaign, sports activities, medical programs and more.
                                </span>
                            </div>
                        </div> 
                    </td>
                    <td>
                        <div class = "card-info">
                            <div class = "card-info-content">
                                <div class = "mission">
                                    <span class = "title">PASAY CITY MISSION</span>
                                    <hr class = "divider">
                                    <span class = "text">
                                        To serve the constituents and stakeholders of Pasay with enthusiasm, efficiency, and a firm commitment to
                                        the principles of good governance; and to provide services and infrastructure essential to making Pasay 
                                        City a safe, progressive, healthy and peaceful place worthy of respect and emulation.
                                    </span>
                                </div>
                                <div class = "vision">
                                    <span class = "title">PASAY CITY VISION</span>
                                    <hr class = "divider">
                                    <span class = "text">
                                        Pasay City - A premier gateway city and world-class destination!
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    <!-- /Content/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../global_assets/js/datetime.js"></script>
</html>