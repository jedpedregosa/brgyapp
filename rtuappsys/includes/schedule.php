<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");

    if(isset($_POST["officeCode"]) && isset($_POST["timeCode"])) {
        echo json_encode(getValues($_POST["officeCode"], $_POST["timeCode"])); 
        // Lacks catch if db fails !!!!!!!!!!!!!!!!
    } else {
        header("Location: ../../main/rtuappsys.php");
    }
?>