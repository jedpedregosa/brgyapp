<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../../logout");
        exit();
    }

    if(!(isset($_POST["Uname"]))) {
        goPrev();
    }

    $username = $_POST["Uname"];
    if(checkAdminValidity($username)) {
        if(updateStatement("UPDATE tblAdmin_auth SET admnUname = ? WHERE admnUname = ?", [$username, $admn_uid])) {
            $_SESSION["admn_sess_uname"] = $username;
            goPrev(100);
        }
        goPrev();
    } else {
        goPrev();
    }

    function goPrev($code = 101) {
        $_SESSION["admn_update_res"] = $code;
        header("Location: ../../e-services/barangay-profile");
        exit();
    }
?>