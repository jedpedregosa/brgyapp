<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    // Check if request is not from ajax
    if(!IS_AJAX) {
        header("Location: ../main/rtuappsys");
		die();
    }

    // Session Side
    //session_name("id");
   // session_start();

    //if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        //echo json_encode(array("statusCode"=>203)); // User is not sessioned
    //} 

    if(isset($_POST["branch"])) {
        $campus = $_POST["branch"];

        $offices_without_admin = getUnassignedOffices($campus);
        echo json_encode($offices_without_admin);
    } else {
        // *********** Needs error message
        header("Location: ../main/rtuappsys");
        die();
    }
?>