<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		sub-appointment.php (API, Ajax) -- 
 *  Description:
 * 		1. Submits the overall appointment information.
 * 
 * 	Date Created: 30th of July, 2021
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

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/module.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Visitor.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");

    // Check if request is not from ajax
    if(!IS_AJAX) {
        header("Location: ../main/rtuappsys");
		die();
    }

    // Check if from a page request 
	if(isset($_POST['branch']) && isset($_POST['officeId']) && isset($_POST['date']) && isset($_POST['purpose'])) {
		$branch = $_POST['branch'];
		$office = $_POST['officeId'];
		$date = $_POST['date'];
		$purpose = $_POST['purpose'];
        $time = $_POST['time'];
	} else {
		header("Location: ../main/rtuappsys");
		die();
	}

    $isSessioned = true;
    $isSuccess = null;

    session_name("id");
	session_start();

	if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        $isSessioned = false;
    } 

    if($isSessioned) {
        $userId = $_SESSION["userId"];
		$userType = $_SESSION["uType"];

        // !!!: Lacks date format checker
        $slctd_date = new DateTime($date);
        $submtDate = $slctd_date->format('ymd');
        $dateForSched = $slctd_date->format('Y-m-d');
        $officeId = str_replace("RTU-O", "", $office);
        $timeId = str_replace("TMSLOT-", "", $time);
        $schedId = $submtDate . $officeId . $timeId;
        if ($submtDate !== false) { // Check if date formata is valid ::::::: Not reliable
            checkTimeSlotValidity($date, $office, $time, $schedId);
            // !!!: Lacks Date Availability Checker
            if(isSchedAvailable($schedId)) {
                if(!doesSchedExist($schedId)) {
                    // !!!: Lacks Time Slot Id && Office Id Availability Checker
                    createSched($schedId, $dateForSched, $time, $office); // Lacks Query Catch
                } 
                $vstor_id = getVisitorId($userId, $userType);

                $app_id = getAppointmentIdByVisitor($vstor_id);

                $allowed = true;

                if($app_id) {
                    if(isAppointmentDone($app_id)) {
                        deleteAppointmentData($app_id);
                    } else {
                        $allowed = false;
                    }
                }

                if($allowed) {
                    $isSuccess = createAppointment($schedId, $vstor_id, $branch, $office, $purpose);
                }
            }
        } else {

        }
    }

    if ($isSuccess) { // If create appointment succeed
        $_SESSION["applicationId"] = $isSuccess;
		echo json_encode(array("statusCode"=>200)); // 200 : Register Success
	} else if(!$isSessioned) {
		echo json_encode(array("statusCode"=>201)); // 201 : No Sessioned Appointees
	} else {
		echo json_encode(array("statusCode"=>202)); // 202 : Register Error (Email is taken)
	}
?>