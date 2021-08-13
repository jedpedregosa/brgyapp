<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Admin.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Visitor.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Feedback.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    session_name("cid");
    session_start();

    $admin_id;
    
    if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"])) {
        $doesDataExists = doesUserHasData($_SESSION["admin_uname"]);
        $isAuthValid = isPasswordValid($_SESSION["admin_uname"], $_SESSION["admin_chng"]);
        if(!$isAuthValid || !$doesDataExists) {
            unset($_SESSION["admin_uname"]);
            unset($_SESSION["admin_chng"]);

            header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/app");
            die();
        }
        $admin_id = $_SESSION["admin_uname"];
    } else {
        header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/app");
        die();
    }

    $full_name = getFullName($admin_id);
    $assigned_office = getAssignedOffice($admin_id);

    $message;
    $title;
    $success = false;
    $task_error = false;

    if(isset($_SESSION["err_oadmin"])) {
        if($_SESSION["err_oadmin"] == 200) {
            $affected_count = $_SESSION["close_sched_status"];
            
            $title = "Result";
            $message = "Total of " . $affected_count . " schedules affected.";
            
            $success = true;
            unset($_SESSION["close_sched_status"]);
        } else if($_SESSION["err_oadmin"] == 300) {
            $title = "Appointment";
            $message = "Task executed successfully.";
            $success = true;
        } else if($_SESSION["err_oadmin"] == 301) {
            $title = "Appointment";
            $message = "Oops, something went wrong. Please try again.";
            $task_error = true;
        } else if($_SESSION["err_oadmin"] == 302) {
            $title = "Not Found";
            $message = "Oops, this appointment cannot be found.";
            $task_error = true;
        }
        unset($_SESSION["err_oadmin"]);
    }
?>
	
