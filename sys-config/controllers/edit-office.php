<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		edit-office.php (Access Page) -- 
 *  Description:
 * 		1. Edits an office information.
 * 
 * 	Date Created: 18th of August, 2021
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
    
    $office_id;
    $office_name;
    $office_desc = null;
    $office_accepts = 0;

    if(isset($_POST["updoffice"])) {
        if(isset($_POST["editoffid"]) && isset($_POST["editoffn"]) && isset($_POST["editoffdsc"])) {
            $office_id = $_POST["editoffid"];
            $office_name = htmlspecialchars($_POST["editoffn"]);
            $office_desc = htmlspecialchars($_POST["editoffdsc"]);

            if(isset($_POST["editaccept"])) {
                $office_accepts = 1;
            }
        } else {
            goBack();
        }
    } else {
        goBack();
    }

    if(!doesOfficeExist($office_id)) {
        goBack();
    }

    $office_name = addslashes($office_name);
    $office_desc = addslashes($office_desc);
    
    $result = updateOfficeData($office_id, $office_name, $office_desc, $office_accepts);

    if($result === 300 || $result === 301) {
        $_SESSION["updt_office"] = $office_id;
    }

    goBack($result);

    function goBack($errorCode = 302) {
        $_SESSION["updt_res"] = $errorCode;
        header("Location: ../page/office");
        die();
    } 
?>