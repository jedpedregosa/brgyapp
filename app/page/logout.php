<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/SystemLog.php");

    session_name("cid");
    session_start();

    $nameToLog = "A user";
    if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"])) {
        $nameToLog = $_SESSION["admin_uname"];

        unset($_SESSION["admin_uname"]);
        unset($_SESSION["admin_chng"]);
        unset($_SESSION["admin_session_expiry"]);
    }

    createLog($nameToLog, "7", USER_IP);

    header("Location: ../login");
    die();
?>