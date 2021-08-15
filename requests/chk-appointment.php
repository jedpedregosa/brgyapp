<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		chk-appointment.php (Access Page, Module) -- 
 *  Description:
 * 		1. Checks wether the provided information
 *          has an appointment booked.
 * 		2. If not, initiate session consisting
 *          the identification information provided.
 * 
 * 	Date Created: 7th of July, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	Triggers for validation messages for the client side.
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 * **************************************************************************/

    // Includes
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/module.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Visitor.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
    
    // Initialization
    $userId;            // Student Number, Employee Number or Email
    $uLname;            // Visitor Last Name
    $uType;             // Student, Employee, Guest

    // Check if accessed from rtuappsys.php
    if(isset($_GET["type"])) {
        $uType = $_GET["type"];
        if(isset($_POST["studentNum"]) && isset($_POST["sLname"])) {
            // Check if student number has an ongoing appointment
            if(doesUserHasApp($_POST["studentNum"], "student")) {
                // *********** Needs error message
                goBack();
            }
            $userId = $_POST["studentNum"];
            $uLname = $_POST["sLname"];
            // ********* Needs format checker for student number
        } else if(isset($_POST["empNum"]) && isset($_POST["eLname"])) {
            if(doesUserHasApp($_POST["empNum"], "employee")) {
                // *********** Needs error message
                goBack();
            }
            $userId = $_POST["empNum"];
            $uLname = $_POST["eLname"];
        } else if(isset($_POST["email"]) && isset($_POST["gLname"])) { 
            if(doesEmailHasApp($_POST["email"])) {
                // *********** Needs error message
                goBack();
            }
            $userId = $_POST["email"];
            $uLname  = $_POST["gLname"];
        } else {
            // If none of the post values were assigned, go back to main website page.
            header("Location: ../main/rtuappsys");
            die();
        }
    } else {
        // If none of the get value were assigned, go back to main website page.
        header("Location: ../main/rtuappsys");
        die();
    } 

    // If none of the get value were assigned, go back to main website page.
    if(!(isTypeValid($uType))) {
        header("Location: ../main/rtuappsys");
        die();
    }


    // Session Side
    session_name("id");
    session_start();

    // Assigning Session
    $_SESSION["userId"] = $userId;
    $_SESSION["uLname"] = $uLname;
    $_SESSION["uType"] = $uType;

    $vstor_id = getVisitorId($userId, $uType);

    if($vstor_id) {
        $app_id = getAppointmentIdByVisitor($vstor_id);

        if($app_id) {
            if(isAppointmentDone($app_id)) {
                deleteAppointmentData($app_id);
            } else {
                goBack();
            }
        }
    }

    // Continue to creating appointment
    header("Location: ../main/create/appointment");

    function goBack() {
        session_name("cid");
        session_start();

        $_SESSION["error_status"] = 200;

        header("Location: ../main/rtuappsys");
        die();
    }
?>