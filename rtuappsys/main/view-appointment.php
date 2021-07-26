<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");

    // Session Side
    session_name("cid");
    session_start();

    if(isset($_GET["islogout"])) {
        if($_GET["islogout"]) {
            unset($_SESSION["view_email"]);
            unset($_SESSION["view_lastname"]);
        }
    }

    $v_email;
    $v_lname;

    $v_user_type;
    $v_data = [];
    $v_app_data = [];
    $scheduled_date;
    $app_key;
    
    $isStudent = false;
    $isEmp = false;
    $isGuest = false;

    // Check if accessed from chck-appointment.php
    if(!(isset($_SESSION["view_email"]) && isset($_SESSION["view_lastname"]))) {
        if(isset($_POST["view_email"]) && isset($_POST["view_lname"])) {
            $_SESSION["view_email"] = $_POST["view_email"];
            $_SESSION["view_lastname"] = $_POST["view_lname"];
    
            header("Location: view-appointment.php");
        } else {
            header("Location: rtuappsys.php");
            die();
        }
    } else {
        $v_email = $_SESSION["view_email"];
        $v_lname = $_SESSION["view_lastname"];

        if(doesEmailHasApp($v_email)) {
            $v_user_type = getUserTypeByEmail($v_email);
            $v_data = getUserDataByEmailLastN($v_email, $v_lname, $v_user_type);

            if($v_data) {
                //Is appointment not done
                if(!isAppointmentDoneByEmail($v_email)) {
                    $v_app_data = getAppointmentDetailsByEmail($v_email);
                    $sched_data = getScheduleDetailsByAppointmentId($v_app_data[0]);
                    $office_slot = getValues($v_app_data[2], $sched_data[2]);
                    
                    $schedDate = new DateTime($sched_data[4]);
                    $scheduled_date = $schedDate->format("F d, Y");

                    $app_key = getAppointmentKeyByAppointmentId($v_app_data[0]);
                } else {
                    goBack();
                }
            } else {
                goBack();
            }
        } else {
            goBack();
        }
    }

    if($v_user_type == "student") {
        $isStudent = true;
    } else if($v_user_type == "employee") {
        $isEmp = true;
    } else {
        $isGuest = true;
    } 

    function goBack() {

        $_SESSION["error_status"] = 201;
        unset($_SESSION["view_email"]);
        unset($_SESSION["view_lastname"]);

        header("Location: rtuappsys.php");
        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title> View Appointment </title>
    <link rel="stylesheet" href="../assets/css/ViewAppointmentStyle.css"/>
</head>
<body onload=display_ct();>
    <header class="header">
        <div class="logo">
            <img src="../assets/img/rtu.png"/>
            <div class="status">
                <div class="greet">
                    Welcome, <?php echo htmlspecialchars($v_data[0]);?>!
                </div>

                <div class="log_out">
                    <a href="view-appointment.php?islogout=1"><img src="../assets/img/log_out.png"></a>
                </div>

                <div class="time">
                </div>

                <div class="date">
                    <script src="../assets/js/view_app_script.js?version=2"></script>
                </div>
            </div>
        </div>  
    </header>

    <div class="information">
        <h4><span style="color:#EAB800;"> my</span><span style="color:#002060;">Appointment </span></h4>
        <ul>
            <!-- Put here the inputted personal information -->
            <li class="li1"><b>PERSONAL INFORMATION</b></li>

            <div class="div1">
                <?php 
                    if($isStudent) {
                        ?>
                            <b>STUDENT NUMBER&nbsp;</b>&nbsp;<?php echo htmlspecialchars($v_data[2]);?><br>
                        <?php
                    } else if($isEmp) {
                        ?>
                            <b>EMPLOYEE NUMBER&nbsp;</b>&nbsp;<?php echo htmlspecialchars($v_data[2]);?><br>
                        <?php
                    } else {
                        ?>
                            <b>EMAIL ADDRESS&emsp;&ensp;</b>&nbsp;<?php echo htmlspecialchars($v_email);?><br>
                        <?php
                    }
                ?>
                
                <b>FULL NAME&emsp;&emsp;&emsp;&ensp;&nbsp;</b>&nbsp;<?php echo htmlspecialchars($v_lname . ", " . $v_data[0]);?><br>
                <b>CONTACT NUMBER&nbsp;</b>&nbsp;<?php echo htmlspecialchars($v_data[1]);?><br>
                <?php 
                    if($isGuest) {
                        ?>
                            <b>AFFILIATED COMPANY</b>&nbsp;<?php echo htmlspecialchars($v_data[2]);?><br>
                        <?php
                    } else {
                        ?>
                            <b>EMAIL ADDRESS&emsp;&ensp;</b>&nbsp;<?php echo htmlspecialchars($v_email);?><br>
                        <?php
                    }
                ?>
            </div>

            <!-- Put here the inputted appointment information -->
            <li class="li2"><b>APPOINTMENT INFORMATION</b></li>

            <div class="div2">
                <div class="column left">
                    <b>RTU BRANCH&emsp;&ensp;&ensp;</b>&nbsp;<?php echo htmlspecialchars($v_app_data[3]);?><br>
                    <b>OFFICE NAME&emsp;&ensp;</b>&nbsp;<?php echo htmlspecialchars($office_slot["officeValue"]);?><br>
                    <?php 
                        if($isGuest) {
                            ?>
                                <b>GOVERNMENT ID</b>&nbsp;<?php echo htmlspecialchars($v_data[3]);?><br>
                            <?php
                        }
                    ?>
                    <b>DATE&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&ensp;</b>&nbsp;<?php echo htmlspecialchars($scheduled_date);?><br>
                    <b>TIME&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&ensp;</b>&nbsp;<?php echo htmlspecialchars($office_slot["timeValue"]);?><br>
                    <b>PURPOSE&emsp;&emsp;&emsp;&ensp;&nbsp;</b>&nbsp;<?php echo htmlspecialchars($v_app_data[4]);?><br><br>
                </div>
            </div>
        </ul>
        <div class="qr">
            <img src="../assets/files/<?php echo $app_key; ?>/<?php echo $v_app_data[0];?>.png" width="796" height="153"><br>
            <a class="submit dlbutton" href = "../assets/files/<?php echo $app_key; ?>/RTUAppointment-<?php echo $v_app_data[0];?>.pdf"> DOWNLOAD APPOINTMENT SLIP </a>
        </div>
    </div>

    <!-- DESIGN -->
    <div class="design">
        <div class="a">
            <img src="../assets/img/design.png" width="100" height="100"> 
        </div>
        <div class="b">
            <img src="../assets/img/design.png" width="100" height="100"> 
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="footer-bottom">
            COPYRIGHT &copy; 2021 RIZAL TECHNOLOGICAL UNIVERSITY<!-- COPYRIGHT -->
        </div>
    </div>

</body>
</html>