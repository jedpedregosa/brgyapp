<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		edit-admin.php (Access Page) -- 
 *  Description:
 * 		1. Submits the new office admin information.
 *      2. Password reset feature
 * 
 * 	Date Created: 19th of August, 2021
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

    if(isset($_POST["edt_adm"])) {
        $post1 = isset($_POST["editadmid"]) && isset($_POST["editadmfname"]) && isset($_POST["editadmlname"]);
        if(isset($_POST["editadmail"]) && isset($_POST["editadmcntct"]) && $post1) {
            $admin_id = $_POST["editadmid"];
            $fname = $_POST["editadmfname"];
            $lname = $_POST["editadmlname"];
            $email = $_POST["editadmail"];
            $contact = $_POST["editadmcntct"];

            $result = updateData($admin_id, $fname, $lname, $email, $contact);

            if($result) {
                $_SESSION["updt_admid"] = $admin_id;
                goBack(400);
            } else {
                goBack();
            }
        } else {
            goBack();
        }
    } else if(isset($_POST["edt_adm_pass"])) {
        if(isset($_POST["editadmid"])) {
            $admin_id = $_POST["editadmid"];
            $new_pass = generateRandomString();

            $result = changeAdminPassword($admin_id, $new_pass);

            if($result) {
                $_SESSION["updt_pass"] = $new_pass;
                $_SESSION["updt_admid"] = $admin_id;

                goBack(400);
            } 
            goBack();
        } else {
            goBack();
        }
    }
    goBack();

    function goBack($errorCode = 401) {
        $_SESSION["updt_res"] = $errorCode;
        header("Location: ../page/office");
        die();
    }
?>