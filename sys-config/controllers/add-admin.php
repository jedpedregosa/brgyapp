<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		add-admin.php (Access Page) -- 
 *  Description:
 * 		1. Submit the new office admin information.
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

    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php"); 

    if(isset($_POST["add_admin"])) {
        $post_valid1 = isset($_POST["oa-lastname"]) && isset($_POST["oa-firstname"]) && isset($_POST["oa-email"]);
        $post_valid2 = isset($_POST["oa-contact"]) && isset($_POST["oa-office"]);
        if(!($post_valid1 && $post_valid2)) {
            goBack();
        }
    } else {
        goBack();
    }

    $lname = $_POST["oa-lastname"];
    $fname = $_POST["oa-firstname"];
    $email = $_POST["oa-email"];
    $contact = $_POST["oa-contact"];
    $pass = generateRandomString();
    $office = $_POST["oa-office"];

    
    $oadmn_id = addAdminAccount($lname, $fname, $email, $contact, $pass, $office, $pass);
    
    if($oadmn_id) {
        if(addAdminAuth($oadmn_id, $pass)) {
            $_SESSION["add-admin-id"] = $oadmn_id;
            $_SESSION["add-admin-pw"] = $pass;
            goBack(300);   
        }
    }

    function goBack($errorCode = 301) {
        $_SESSION["err_code"] = $errorCode;
        header("Location: ../page/office");
        die();
    }
?>