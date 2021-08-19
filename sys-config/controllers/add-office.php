<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		add-office.php (Access Page) -- 
 *  Description:
 * 		1. Submits the new office information.
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

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");

    session_name("cid");
    session_start();

    $off_name;
    $off_camp;
    $off_desc;
    $off_accepts = 0;

    if(isset($_POST["sbmt_add"])) {
        if(isset($_POST["ofcname"]) && isset($_POST["off_campus"]) && isset($_POST["desc"])) {
            $off_name = $_POST["ofcname"];
            $off_camp = $_POST["off_campus"];
            $off_desc = $_POST["desc"];

            if(isset($_POST["accepts_app"])) {
                $off_accepts = 1;
            }
        } else {          
            goBack();
        }
    } else {
        goBack();
    }

    if($off_camp != "Boni Campus" && $off_camp != "Pasig Campus") {
        goBack();
    }

    $result = createOffice($off_name, $off_camp, $off_desc, $off_accepts);

    if($result) {
        $_SESSION["add_office_id"] = $result;
        goBack(300);
    }

    goBack();

    function goBack($errorCode = 301) {
        $_SESSION["err_code"] = $errorCode;
        header("Location: ../page/office");
        die();
    }
?>