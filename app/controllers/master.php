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
    
    if(boolval(sys_in_maintenance)) {
        $_SESSION["admin_err"] = 505;
        header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/app/page/logout");
    }

    if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"]) && $_SESSION["admin_session_expiry"]) {
        $doesDataExists = doesUserHasData($_SESSION["admin_uname"]);
        $isAuthValid = isPasswordValid($_SESSION["admin_uname"], $_SESSION["admin_chng"]);
        if(!$isAuthValid || !$doesDataExists) {
            unset($_SESSION["admin_uname"]);
            unset($_SESSION["admin_chng"]);
            unset($_SESSION["admin_session_expiry"]);

            header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/app");
            die();
        }
        if($_SESSION["admin_session_expiry"] < time()) {
            header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/app/page/logout");
            die();
        }

        $admin_id = $_SESSION["admin_uname"];
    } else {
        header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/app");
        die();
    }

    $full_name = getFullName($admin_id);
    $assigned_office = getAssignedOffice($admin_id);

    // Checkers
    checkAllAppointments($assigned_office);

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
	
