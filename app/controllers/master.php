<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Admin.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    session_name("cid");
    session_start();

    $admin_id;
    
    if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"])) {
        if(!isPasswordValid($_SESSION["admin_uname"], $_SESSION["admin_chng"])) {
            unset($_SESSION["admin_uname"]);
            unset($_SESSION["admin_chng"]);

            header("Location: ../login");
            die();
        }
        $admin_id = $_SESSION["admin_uname"];
    } else {
        header("Location: ../login");
        die();
    }

    $full_name = getFullName($admin_id);
    $assigned_office = getAssignedOffice($admin_id);

    $message;
    $title;

    if(isset($_SESSION["err_oadmin"])) {
        if($_SESSION["err_oadmin"] == 200) {
            $affected_count = $_SESSION["close_sched_status"];
            
            $title = "Closing Schdule Slots";
            $message = "Total of " . $affected_count . " schedules are closed.";
            
            unset($_SESSION["close_sched_status"]);
        }
        unset($_SESSION["err_oadmin"]);
    }
?>