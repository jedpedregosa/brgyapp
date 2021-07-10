<?php 

    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");


    if(isset($_POST["email"])) {
        $email = $_POST["email"];
        if(doesUserHasApp($email, "guest")) {
            echo json_encode(array("hasEmail"=>200)); // Email Not Available
        } else {
            echo json_encode(array("hasEmail"=>201)); // Email Available
        }
        
    } else {
        header("Location: ../main/rtuappsys.php");
    }
?>