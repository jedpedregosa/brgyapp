<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/module.php");

    /*
    // Check if from a page request 
	if(isset($_POST['branch']) && isset($_POST['officeId']) && isset($_POST['date']) && isset($_POST['purpose'])) {
		$branch = $_POST['branch'];
		$office = $_POST['officeId'];
		$date = $_POST['date'];
		$purpose = $_POST['purpose'];
        $time = $_POST['time'];
	} else {
		header("Location: ../main/rtuappsys.php");
		die();
	}*/

    $branch = "Boni Campus";
	$office = "RTU-O01";
	$date = "2021-07-19";
    $purpose = "Burat";
    $time = "TMSLOT-01";

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
            // !!!: Lacks Date Availability Checker
            if(isSchedAvailable($schedId)) {
                if(!doesSchedExist($schedId)) {
                    // !!!: Lacks Time Slot Id && Office Id Availability Checker
                    createSched($schedId, $dateForSched, $time, $office); // Lacks Query Catch
                } 
                $vstor_id = getVisitorId($userId, $userType);
                $isSuccess = createAppointment($schedId, $vstor_id, $branch, $office, $purpose);
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