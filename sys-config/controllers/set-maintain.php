<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/SystemLog.php");

    $main_status = 0;
    if(isset($_POST["set_mtn"])) {
        if(isset($_POST["btn_main"])) {
            $main_status = 1;
        }
    } else {
        goBack();
    }

    $result = updateSystemStatus($main_status);

    if($result) {
        createLog($config_admin_id, "9", USER_IP);
        
        goBack(300);
    } 

    goBack();
    
    function goBack($errorCode = 301) {
        $_SESSION["upd_sys_config"] = 301;
        header("Location: ../page/sys-settings");
    }
?>