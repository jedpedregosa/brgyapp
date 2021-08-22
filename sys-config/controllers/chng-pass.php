<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");

    if(!(isset($_POST["currentPassword"]) && isset($_POST["newPassword"]) && isset($_POST["cNewPassword"]))) {
        goBack();
        
    } 

    $current = $_POST["currentPassword"];
    $new = $_POST["newPassword"];
    $confirm = $_POST["cNewPassword"];

    if(!secureStringValidation($new, 12, 15)) {
        goBack();
    }

    if($new != $confirm) {
        goBack();
    }

    if(!configIsAuthenticated($config_admin_id, $current)) {
        goBack(601);
    }

    if(changeConfigPassword($config_admin_id, $new)) {
        header("Location: ../page/logout");
        die();
    }
    goBack();

    function goBack($errorCode = 602) {
        $_SESSION["upd_sys_config"] = $errorCode;
        header("Location: ../page/sys-settings");
        die();
    }

?>