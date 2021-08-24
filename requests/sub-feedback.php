<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		sub-feedback.php (Access Page) -- 
 *  Description:
 * 		1. Submits the overall feedback information.
 * 
 * 	Date Created: 14th of August, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	
 *  Lacks: 
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 ******************************************************************************/

    include_once($_SERVER['DOCUMENT_ROOT'] . "/main/master.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Feedback.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Validation.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/module.php");

    session_name("cid");
    session_start();

    $fname = null;
    $cat = null; 
    $email = null;
    $contact = null;
    $office = null;
    $feedback = null;
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST["sbmt_feedback"])) {
            $val1 = isset($_POST["fullname"]) && isset($_POST["category"]) && isset($_POST["email"]) && isset($_POST["contact"]);
            if($val1 && isset($_POST["office"]) && !empty($_POST["feedback"])) {
                $fname = valid_input($_POST["fullname"]);
                $cat = valid_input($_POST["category"]);
                $email = valid_input($_POST["email"]);
                $contact = valid_input($_POST["contact"]);
                $office = $_POST["office"];
                $feedback = valid_input($_POST["feedback"]);
                $isSatisfied = ($_POST["isSatisfied"] ? 1 : 0);
            } else {
                goBack();
            }
        } else {
            goBack();
        }
    } else {
        goBack();
    }
    
    if(!doesOfficeExist($office)) {
        goBack();
    }

    $lengthVal = lengthValidation($fname, 2, 100) && lengthValidation($email, 2, 30) && lengthValidation($contact, 2, 20) && lengthValidation($feedback, 5, 160);
    if(!($lengthVal && isTypeValid($cat))) {
        goBack();
    }

    $response = saveFeedback($fname, $cat, $contact, $office, $email, $feedback, $isSatisfied, USER_IP);

    if($response) {
        $_SESSION["error_status"] = 300;
        header("Location: ../main/rtuappsys");
    } else {
        goBack();
    }

    function goBack($error_code = 301) {
        $_SESSION["error_status"] = $error_code;
        header("Location: ../main/feedback");
        die();
    }
?>