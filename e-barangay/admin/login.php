<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if($is_admn_lgn) {
        header("Location: home");
        exit();
    }
    
    $has_msg = false;
    $msg;

    if(isset($_SESSION["res_admin_type"])) {
        $has_msg = true;
        
        switch($_SESSION["res_admin_type"]) {
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

        unset($_SESSION["res_admin_type"]);
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
        <div class = "content adjust">
            <div class = "container-login">
                <h3 class = "title">ADMIN'S LOGIN</h3>
                <form action = "controllers/admin/check-auth" method = "POST">
                    <div class = "container-field">
                        <input type = "text" class = "sys-text" placeholder = "Email or username" name = "lgnUname" minlength = "2" maxlength = "40" required>
                        <input type = "password" class = "sys-text" placeholder = "Password" name = "lgnPword" minlength = "2" maxlength = "20" required>
            <?php 
                if($has_msg) {
                    ?>
                        <span class = "validate-msg val-lg"><?php echo $msg; ?></span>
                    <?php
                }
            ?>
                    </div>
                    <div class = "button-group">
                        <input type = "submit" class = "sys-button" name = "sbmt-admn-lgn" value = "L O G I N">
                    </div>
                </form>
                <input class = "sys-button admin" onclick = "location.href='../guest/login'" value = "U S E R S  L O G I N">
            </div>
        </div>
    <!-- /Content/ -->
        <div class = "main-footer foot-adjust">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../global_assets/js/datetime.js"></script>
</html>