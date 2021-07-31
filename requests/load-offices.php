<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    // Check if request is not from ajax
    if(!IS_AJAX) {
        header("Location: ../main/rtuappsys");
		die();
    }

    // Session Side
    session_name("id");
    session_start();

    if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        echo json_encode(array("statusCode"=>203)); // User is not sessioned
    } 

    if(isset($_POST["branch"])) {
        $campus = $_POST["branch"];

        echo json_encode(getOffices($campus));
    } else {
        // *********** Needs error message
        header("Location: ../main/rtuappsys");
        die();
    }
?>