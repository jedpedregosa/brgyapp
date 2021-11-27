<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");

    if($is_resdnt_lgn) {
        header("Location: home");
        exit();
    }
    
    $has_msg = false;
    $msg;

    if(isset($_SESSION["res_resdnt_type"])) {
        $has_msg = true;
        
        switch($_SESSION["res_resdnt_type"]) {
            case 101:
                $msg = "Username or password not found.";
                break;
            case 102:
                $msg = "This account is currently blocked.";
                break;
            case 103:
                $msg = "There's a problem with your request, please try again.";
                break;
            default:
                $has_msg = false;
        }

        unset($_SESSION["res_resdnt_type"]);
    }
?>
<html>
    <head>
        <title>e-Barangay</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../global_assets/css/master.css">
        <link rel="stylesheet" href="../global_assets/css/login.css">
        
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
        <div class = "content">
            <div class = "msg">
                <p class = "msg-header msg-italic">Data Privacy Notice</p>
                <span class = "msg-info msg-italic msg-sm">
                    Data Privacy Law of 2012 (RA10173): Adhere to Data Privacy Law of 2012 (RA10173) the information provided by the 
                    people of Barangay 108 Zone 12 is strictly for this website only. Details are only accessible by the Barangay 
                    Official Admin for their documentation. We are committed to protect the confidentiality of the personal information
                     you will provide and we are bound to comply with Data Privacy Act of 2012 (RA10173). By signing up in this website,
                      you are consenting to our collection and use of information in pursuant with this Privacy Notice.
                </span>
            </div>
            <div class = "container-login">
                <form action = "controllers/acc/check-auth" method = "POST">
                    <div class = "container-field">
                        <input type = "text" class = "sys-text" name = "lgnUname" placeholder = "Email / Username / Contact Number" max = "40" required>
                        <input type = "password" class = "sys-text" name = "lgnPword" placeholder = "Password" max = "20" required>
            <?php 
                if($has_msg) {
                    ?>
                        <span class = "validate-msg val-lg"><?php echo $msg; ?></span>
                    <?php
                }
            ?>
                    </div>
                    <div class = "button-group">
                        <input type = "submit" class = "sys-button" name = "sbmt-gst-lgn" value = "L O G I N">
                        <input type = "button" class = "sys-button" onclick = "location.href='sign-up'" value = "S I G N  UP">
                    </div>
                </form>
                <input class = "sys-button admin" onclick = "location.href='../admin/login'" value = "A D M I N  L O G I N">
            </div>
        </div>
    <!-- /Content/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../global_assets/js/datetime.js"></script>
</html>