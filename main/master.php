<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    if(boolval(sys_in_maintenance)) {
        header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/main/rtuappsys");
        die();
    }
?>