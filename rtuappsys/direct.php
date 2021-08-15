<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Admin.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    session_name("cid");
    session_start();
    
    if(isset($_GET["an_"])) {
        if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"])) {
            $doesDataExists = doesUserHasData($_SESSION["admin_uname"]);
            if(!isPasswordValid($_SESSION["admin_uname"], $_SESSION["admin_chng"]) && $doesDataExists) {
                unset($_SESSION["admin_uname"]);
                unset($_SESSION["admin_chng"]);
    
                infoFail();
            }
            header("Location: ../app/page/view/result?app_=" . $_GET["an_"]);
        } else {
            infoFail();
        }
    } else {
        infoFail();
    }
    

    function infoFail() {
        header("Location: ../main/rtuappsys");
        die();
    }
?>