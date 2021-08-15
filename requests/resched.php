<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Schedule.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Validation.php");

    // Session Side
    session_name("cid");
    session_start();

    $v_email;
    $v_lname;

    $slct_date;
    $tmslot_id;

    $v_app_data = [];
    $sched_data = [];

    if(isset($_SESSION["view_email"]) && isset($_SESSION["view_lastname"])) {
        $v_email = $_SESSION["view_email"];
        $v_lname = $_SESSION["view_lastname"];
        
        if(doesEmailHasAppData($v_email)) {
            $v_app_data = getAppointmentDetailsByEmail($v_email);
            $sched_data = getScheduleDetailsByAppointmentId($v_app_data[0]);
            
        } else {
            goBack();
        }
    } else {
        goBack();
    }

    if(isset($_POST["slct_date"]) && isset($_POST["time_slt"])) {
        if(validateDate($_POST["slct_date"]) && validateTimeSlotId($_POST["time_slt"])) {
            $slct_date = $_POST["slct_date"];
            $tmslot_id = $_POST["time_slt"];
        } else {
            goBack();
        }
    } else {
        goBack();
    }
    
    if($slct_date == $sched_data[4] && $tmslot_id == $sched_data[2]) {
        goBack(302);
    }

    if(!isReschedAllowed($v_app_data[0]) && !isSchedClosed($v_app_data[1])) {
        goBack();
    }

    $result = reschedAppointment($v_app_data[0], $slct_date, $tmslot_id);

    
    if($result) {
        if((int)$result == 101) {
            goBack(301);
        } else {
            goBack(300);
        }
    } else {
        goBack();
    }

    

    function goBack($errorCode = 303) {
        $_SESSION["alrt_chngschd"] = $errorCode;
        header("Location: ../main/view-appointment");
        die();
    }
?>