<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/module.php");
    // Check if accessed from rtuappsys.php

    $userId;
    $uLname;
    $uType;

    if(isset($_GET["type"])) {
        $uType = $_GET["type"];
        if(isset($_POST["studentNum"]) && isset($_POST["sLname"])) {
            // Check if student number has an ongoing appointment
            if(doesUserHasApp($_POST["studentNum"], "student")) {
                // *********** Needs error message
                echo "<script>alert('this info has made an appointment already');</script>";
                header("Location: ../main/rtuappsys.php");
                die();
            }
            $userId = $_POST["studentNum"];
            $uLname = $_POST["sLname"];
            // ********* Needs format checker for student number
        } else if(isset($_POST["empNum"]) && isset($_POST["eLname"])) {
            if(doesUserHasApp($_POST["empNum"], "employee")) {
                // *********** Needs error message
                echo "<script>alert('this info has made an appointment already');</script>";
                header("Location: ../main/rtuappsys.php");
                die();
            }
            $userId = $_POST["empNum"];
            $uLname = $_POST["eLname"];
        } else if(isset($_POST["email"]) && isset($_POST["gLname"])) { 
            if(doesEmailHasApp($_POST["email"])) {
                // *********** Needs error message
                echo "<script>alert('this info has made an appointment already');</script>";
                header("Location: ../main/rtuappsys.php");
                die();
            }
            $userId = $_POST["email"];
            $uLname  = $_POST["gLname"];
        } else {
            header("Location: ../main/rtuappsys.php");
            die();
        }
    } else {
        header("Location: ../main/rtuappsys.php");
        die();
    } 

    if(!(isTypeValid($uType))) {
        header("Location: ../main/rtuappsys.php");
        die();
    }

    session_name("id");
    session_start();

    $_SESSION["userId"] = $userId;
    $_SESSION["uLname"] = $uLname;
    $_SESSION["uType"] = $uType;

   header("Location: ../main/create/appointment.php");
?>