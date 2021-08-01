<?php 
    session_name("cid");
    session_start();

    if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"])) {
        unset($_SESSION["admin_uname"]);
        unset($_SESSION["admin_chng"]);
    }

    header("Location: ../login");
    die();
?>