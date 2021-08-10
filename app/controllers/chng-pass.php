<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");

    $current_pass = null;
    $new_pass1 = null;
    $new_pass2 = null;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST["upd_pass"])) {
            if(isset($_POST["currentPassword"]) && isset($_POST["newPassword"]) && isset($_POST["cNewPassword"])) {
                $current_pass = $_POST["currentPassword"];
                $new_pass1 = $_POST["newPassword"];
                $new_pass2 = $_POST["cNewPassword"];
            } else {
                goBack();
            }
        } else {
            goBack();
        }
    }

    if($new_pass1 != $new_pass2) {
        goBack();
    }

    if(userIsAuthenticated($admin_id, $current_pass)) {
        $result = changeAdminPassword($admin_id, $new_pass1);
        $_SESSION["admin_chng"] = getLastPasswordChange($admin_id);
        goBack(300);
    } else {
        goBack(303);
    }

    function goBack($error_code = 305) {
        $_SESSION["upd_alert"] = $error_code;
        header("Location: ../page/profile");
        die();
    }
?>