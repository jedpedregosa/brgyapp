<?php
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		direct.php (Access Page) -- 
 *  Description:
 * 		1. Reads the appointment QR, and navigate to accessible page.
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

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Admin.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    session_name("cid");
    session_start();
    
    if(isset($_GET["an_"])) {
        if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"])) {
            $doesDataExists = doesUserHasData($_SESSION["admin_uname"]);
            if(!isPasswordValid($_SESSION["admin_uname"], $_SESSION["admin_chng"]) && $doesDataExists) {
                unset($_SESSION["admin_uname"]);
                unset($_SESSION["admin_chng"]);
    
                infoFail();
            }
            header("Location: ../app/page/view/result?app_=" . $_GET["an_"]);
        } else if (isset($_SESSION["config_admin_uname"]) && isset($_SESSION["config_admin_chng"])) {
            header("Location: ../sys-config/page/view/result?app_=" . $_GET["an_"]);
        } else {
            infoFail();
        }
    } else {
        infoFail();
    }
    

    function infoFail() {
        header("Location: ../main/rtuappsys");
        die();
    }

?>