<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");

    if(!isset($_POST["username"])) {
        goBack();
    }

    $change_uname = $_POST["username"];

    if(!secureStringValidation($change_uname, 12, 15)) {
        goBack(501);
    }

    if(doesConfigAdminExist($change_uname)) {
       goBack(501);   
    }

    if(configIsAuthenticated($config_admin_id, $change_uname)) {
        $_SESSION["config_admin_uname"] = $change_uname;
        goBack(500);

    } else {
        goBack();
    }

    function goBack($errorCode = 502) {
        $_SESSION["upd_sys_config"] = $errorCode;
        header("Location: ../page/sys-settings");
        die();
    }
?>