<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/AdminConfig.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Admin.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/module.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Feedback.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Validation.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Schedule.php");

    session_name("cid");
    session_start();

    $admin_id;
    
    if(isset($_SESSION["config_admin_uname"]) && isset($_SESSION["config_admin_chng"]) && isset($_SESSION["config_session_expiry"])) {
        $doesDataExists = doesConfigAdminExist($_SESSION["config_admin_uname"]);
        $isAuthValid = isConfigPasswordValid($_SESSION["config_admin_uname"], $_SESSION["config_admin_chng"]);
        if(!$isAuthValid || !$doesDataExists) {
            unset($_SESSION["config_admin_uname"]);
            unset($_SESSION["config_admin_chng"]);
            unset($_SESSION["config_session_expiry"]);

            header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/sys-config");
            die();
        }
        if($_SESSION["config_session_expiry"] < time()) {

            header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/sys-config/page/logout");
            die();
        }
        $_SESSION["config_session_expiry"] = time() + 60 * (int)config_min_session_expr;

        $config_admin_id = $_SESSION["config_admin_uname"];
        
        checkAllAppointments();
        checkAllScheds();

    } else {
        header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/sys-config");
        die();
    }

    $is_under_maintenance = isUnderMaintenance();
?>