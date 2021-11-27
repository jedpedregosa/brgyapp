<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");

    $off_val = selectStatement("r", "SELECT * FROM tblOfficial", null);

    $req_sql = "SELECT COUNT(*) FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname WHERE resValid = 1";
    $total_population = selectStatement("c", $req_sql, null);
    $total_voter = selectStatement("c", $req_sql . " AND TIMESTAMPDIFF(YEAR, res.resBdate, CURDATE()) > 17 AND NOT ISNULL(NULLIF(resVoter,''))", null);
    $total_male = selectStatement("c", $req_sql . " AND resSex = 'M'", null);
    $total_female = selectStatement("c", $req_sql . " AND resSex = 'F'", null);
    $total_senior = selectStatement("c", $req_sql . " AND TIMESTAMPDIFF(YEAR, res.resBdate, CURDATE()) > 59", null);
    $total_pwd = selectStatement("c", $req_sql . " AND res.isPWD = 1", null);

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
            <table class = "card-grid">
                <tr>
                    <td>
                        <div class = "card-history">
                            <div class = "card-history-content">
                                <h1 class = "card-history-title">History of Barangay 108 Zone 12</h1>
                                <span class = "card-history-text">
                                    During the first Barangay election which happened on May 17, 1982, Kapitan Isla was hailed as the first ever Barangay Captain of Brgy. 108. His reign lasted 8 years when Kapitan Alfredo R. Jondes took the responsibility of the positions. Jondes' governance lasted for 10 years, occupying a total of 3 electoral terms. He was then replaced by lan P. Vendivel during the 2002 Barangay Elections, which took place on the 15th of July of the said year. 
                                    
                                    Vendivel's reign as Barangay Captain only lasted for approximately a year because of his candidacy as City Councilor. Because of this, the First Kagawad of that time, Marcos A. Ereña, replaced Vendivel as the new Barangay Captain. Ereña finished the remaining years of governance up until 2006.
                                    <br><br>
                                    However, lan P. Vendivel is the first ever Barangay 108 Captain who became a City Councilor for 2nd district of Pasay. The 2007 elections happened and a new Brgy. Captain was elected which is Eugenio Marnelego. His governance lasted for only a term until 2010. In 2010, former appointed Brgy. Captain Marcos A. Ereña succeeded in running for the position. He has been serving as the Barangay 108 Captain from 2010 until the present time.
                                    <br><br>
                                    Barangay 108 Zone 12 is located at Santa Clara area under District II legislative jurisdiction of Pasay City. It is composed of 500 estimated families with an estimated population of 2100. Barangay 108 bounded on the east by Aurora Street (Barangay 121 & 120), west by Tramo Street (Barangay 107), North by Antornio Amaiz Avenue (Fommer Cementina Street Barangay 66) and South by Tengco Street (Barangay 109).
                                    <br><br>
                                    Barangay 108 is proud to have our territorial area of jurisdiction of 2.82 Hectares and is surrounded by many busy commercial establishments such as Card Bank Inc, Andok's, Capitol Restaurant and Ramesh Trading Corporation, LBC CARGO Services, Ochoa Pawnshop, Palawan Express and many more offices and Stores.
                                    <br><br>
                                    This small barangay community proud to be the home of middle-class families having most of their income from varying public and private employments, smalls scale business enterprises and professional practices and skills.
                                    <br><br>
                                    Among the various projects offered to our barangay constituents are decloging of canal, beautification of environment, clean-up and green campaign, programang pang edukasyon-distribution of school supplies, project and equipment for disaster preparedness preservation of peace and order of the community, anti-drug program and campaign, sports activities, medical programs and more.
                                    <br><br>
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
            <table class = "card-grid last">
                <tr>
                    <td>
                        <div class = "card-official">
                            <div class = "card-official-title">
                                <span>CURRENT BARANGAY OFFICIALS</span>
                            </div>
                            <table class = "card-official-grid">
                                <tr>
                                    <th>
                                        Full Name
                                    </th>
                                    <th>
                                        Position
                                    </th>
                                </tr>
            <?php 
                if($off_val["req_result"]) {
                    if($off_val["req_val"]) {
                        foreach($off_val["req_val"] as $val) {
                            ?>
                                <tr>
                                    <td>
                                        <input type = "button" class = "button-3 mod" 
                                        onclick = "showImgModal('<?php echo $val['id']; ?>', 6)" 
                                        value = "<?php echo strtoupper($val["name"]); ?>">
                                        
                                    </td>
                                    <td>
                                        <?php echo strtoupper($val["position"]); ?>
                                    </td>                             
                                </tr>
                            <?php
                        }
                    } else {
                        ?>
                            <tr>
                                <td colspan = "2">
                                    No officials found.
                                </td>
                            </tr>
                        <?php
                    }
                }
            ?>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class = "res-sum">
                            <div class = "res-sum-title">RESIDENTS RECORD SUMMARY</div>
                            <table class = "grid-res-sum">
                                <tr>
                                    <td class = "left-col">
                                        <div class = "card-res-sum">
                                            <div class = "card-res-wrap">
                                                <div class = "card-sum-title">TOTAL POPULATION</div>
                                                <table class = "grid-card-sum">
                                                    <tr>
                                                        <td class = "card-icon">
                                                            <i class="fa fa-users" aria-hidden="true"></i>
                                                        </td>
                                                        <td class = "card-value">
                                                            <?php echo (int)$total_population["req_val"]; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td class = "right-col">
                                        <div class = "card-res-sum">
                                            <div class = "card-res-wrap">
                                                <div class = "card-sum-title">REGISTERED VOTERS</div>
                                                <table class = "grid-card-sum">
                                                    <tr>
                                                        <td class = "card-icon">
                                                            <i class="fa fa-address-card" aria-hidden="true"></i>
                                                        </td>
                                                        <td class = "card-value">
                                                            <?php echo (int)$total_voter["req_val"]; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class = "left-col">
                                        <div class = "card-res-sum">
                                            <div class = "card-res-wrap">
                                                <div class = "card-sum-title">MALE</div>
                                                <table class = "grid-card-sum">
                                                    <tr>
                                                        <td class = "card-icon">
                                                            <i class="fa fa-mars" aria-hidden="true"></i>
                                                        </td>
                                                        <td class = "card-value">
                                                            <?php echo (int)$total_male["req_val"]; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td class = "right-col">
                                        <div class = "card-res-sum">
                                            <div class = "card-res-wrap">
                                                <div class = "card-sum-title">FEMALE</div>
                                                <table class = "grid-card-sum">
                                                    <tr>
                                                        <td class = "card-icon">
                                                            <i class="fa fa-venus" aria-hidden="true"></i>
                                                        </td>
                                                        <td class = "card-value">
                                                            <?php echo (int)$total_female["req_val"]; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class = "left-col">
                                        <div class = "card-res-sum">
                                            <div class = "card-res-wrap">
                                                <div class = "card-sum-title">SENIOR CITIZEN</div>
                                                <table class = "grid-card-sum">
                                                    <tr>
                                                        <td class = "card-icon">
                                                            <i class="fa fa-blind" aria-hidden="true"></i>
                                                        </td>
                                                        <td class = "card-value">
                                                            <?php echo (int)$total_senior["req_val"]; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td class = "right-col">
                                        <div class = "card-res-sum">
                                            <div class = "card-res-wrap">
                                                <div class = "card-sum-title">PWD</div>
                                                <table class = "grid-card-sum">
                                                    <tr>
                                                        <td class = "card-icon">
                                                            <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                                        </td>
                                                        <td class = "card-value">
                                                            <?php echo (int)$total_pwd["req_val"]; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- The Modal -->
        <div id="res_img_modal" class="img-modal">

            <!-- The Close Button -->
            <span class="img-close" id = "img-close">&times;</span>

            <!-- Modal Content (The Image) -->
            <img class="img-modal-content" id="sample_photo">

            <!-- Modal Caption (Image Text) -->
            <div id="img_caption"></div>
        </div>
    <!-- /Content/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../global_assets/js/datetime.js"></script>
    <script> 
        let close = document.getElementById("img-close");
        let modal = document.getElementById("res_img_modal");

        function showImgModal (val, type){
            let modalImg = document.getElementById("sample_photo");   

            modal.style.display = "block";
            modalImg.src = "../file/load/img?type=view" + type + "&r_id=" + val;
        }

        close.onclick = function () {
            modal.style.display = "none";
        }
    </script>
</html>