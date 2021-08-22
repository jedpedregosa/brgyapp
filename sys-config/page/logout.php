<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/SystemLog.php");

    session_name("cid");
    session_start();

    $nameToLog = "A user";
    if(isset($_SESSION["config_admin_uname"]) && isset($_SESSION["config_admin_chng"])) {
        $nameToLog = $_SESSION["config_admin_uname"];

        unset($_SESSION["config_admin_uname"]);
        unset($_SESSION["config_admin_chng"]);
        unset($_SESSION["config_session_expiry"]);
    }
    
    
    createLog($nameToLog, "8", USER_IP);

    header("Location: ../login");
    die();
?>