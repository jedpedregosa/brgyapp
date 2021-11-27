<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }

    $donation_sql = "SELECT * FROM tblDonation WHERE donType = 'dntn2'";
    $donation_data = selectStatement("r", $donation_sql, null);
?>
<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../global_assets/css/master.css">
        <link rel="stylesheet" href="../assets/css/request.css">
        
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
        <div class = "content request">
            <table class = "grid">
                <tr>
                    <td>
                        <span class = "request-title"> Barangay Donations </span>
                    </td>
                    <td class = "col-right">
                        <a class = "request-status status-selected" href = "charity-donation">Charity</a>
                        <a class = "request-status" href = "in-kind-donation">In-kind</a>
                    </td>
                </tr>
            </table>
            <hr>
            <div class = "side-menu-button">
                <input type = "button" onclick = "window.open('../../guest/donation', '_blank').focus();" value = "ADD">
                <input type = "button" id = "tool_dlte" value = "DELETE">
            </div>
            <div class = "data-wrapper">    
                <table class = "data-grid" cellspacing = "0">
                    <thead>
                        <th></th>
                        <th>Date</th>
                        <th colspan = "5">DONATION DRIVE</th>
                        <th>POSITION</th>
                        <th>LAST NAME</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>House Number</th>
                        <th>Street</th>
                        <th>Barangay</th>
                        <th>City</th>
                        <th>Postal Code</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Date of Transaction</th>
                            <th>Type of Payment</th>
                            <th>Amount</th>
                            <th>Proof of Payment</th>
                            <th>Remarks</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        
    <?php 
        if($donation_data["req_result"]) {
            if($donation_data["req_val"]) {
                foreach((array)$donation_data["req_val"] as $donation) {
                    $hash_id = hash('sha256', $donation["donationId"] . $donation["sysTime"]);
                    ?>
                        <tr>
                            <td><input type = "radio" class = "slct_row" value = "<?php echo $donation["donationId"]; ?>"/></td>
                            <td><?php echo transformDate($donation["sysTime"], "m-d-y"); ?></td>
                            <td>
                                <?php 
                                    if($donation["transDate"]) {
                                        echo transformDate($donation["transDate"], "M d, Y"); 
                                    } else {
                                        echo "Not Specified";
                                    }       
                                ?>
                            </td>
                            <td><?php echo $donation["payType"]; ?></td>
                            <td><?php echo $donation["payAmmnt"]; ?></td>
                            <td>
                                <?php 
                                    if($donation["hasFile"]) {
                                        ?>
                                            <input type = "button" class = "button-3" 
                                                onclick = "showImgModal('<?php echo $hash_id; ?>', 5)" 
                                                value = "view photo">
                                        <?php
                                    } else {
                                        echo 'No Upload';
                                    }
                                ?>
                            </td>
                            <td><?php echo $donation["remark"]; ?></td>
                            <td><?php echo $donation["position"]; ?></td>
                            <td><?php echo $donation["lName"]; ?></td>
                            <td><?php echo $donation["fName"]; ?></td>
                            <td><?php echo $donation["mInitial"]; ?></td>
                            <td><?php echo $donation["email"]; ?></td>
                            <td><?php echo $donation["contact"]; ?></td>
                            <td><?php echo $donation["hNumber"]; ?></td>
                            <td><?php echo $donation["stName"]; ?></td>
                            <td><?php echo $donation["brgy"]; ?></td>
                            <td><?php echo $donation["city"]; ?></td>
                            <td><?php echo $donation["pCode"]; ?></td>
                        </tr>
                    <?php
                }
            }
        }
    ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <!-- The Modal -->
        <div id="don_img_modal" class="img-modal">

            <!-- The Close Button -->
            <span class="img-close">&times;</span>

            <!-- Modal Content (The Image) -->
            <img class="img-modal-content" id="sample_photo">

            <!-- Modal Caption (Image Text) -->
            <div id="img_caption"></div>
        </div>
    <!-- /Navigation Bar/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../../global_assets/js/datetime.js"></script>
    <script src="../assets/js/donation.js"></script>
</html>