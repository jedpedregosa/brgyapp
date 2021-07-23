<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/module.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/config.php");

    // Check if request is not from ajax
    if(!IS_AJAX) {
        header("Location: ../main/rtuappsys.php");
		die();
    }

	// Check if from a page request 
	if(isset($_POST['lname']) && isset($_POST['fname']) && isset($_POST['email']) && isset($_POST['phone'])) {
		$lname = $_POST['lname'];
		$fname = $_POST['fname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];	
	} else {
		header("Location: ../main/rtuappsys.php");
		die();
	}

	$isSessioned = true;
	$isSuccess = false;
	$isGuest = false;
	$company = null;
	$govId = null;

	session_name("id");
	session_start();

	if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        $isSessioned = false;
    } 

	if($isSessioned) {
		$userId = $_SESSION["userId"];
		$userType = $_SESSION["uType"];

		if($userType == "guest") {
			$isGuest = true;
			if(isset($_POST['company']) && isset($_POST['govId'])) {
				$company = $_POST['company'];
				$govId = $_POST['govId'];
			} else {
				header("Location: ../main/rtuappsys.php");
				die();
			}
		}
		

		if(!(isTypeValid($userType))) {
			header("Location: ../main/rtuappsys.php");
			die();  
		}

		if(doesUserExists($userId, $userType)) {
			if(!doesUserHasApp($userId, $userType)) {
				if(!doesEmailHasApp($email, "guest")) { // Check if email
					if($isGuest) {
						$userData = [$userId, $lname, $fname, $email, $phone, $company, $govId];					
					} else {
						
						$userData = [$userId, $lname, $fname, $email, $phone];
					}
					$isSuccess = updateUserData($userData, $userType);
				}
				
			}

		} else {
			if($isGuest) {
				$userData = [" ", $lname, $fname, $userId, $phone, $company, $govId];
			} else {
				$userData = [$userId, $lname, $fname, $email, $phone];
			}
			$isSuccess = insertUserData($userData, $userType);
		}
		
	}
    
    if ($isSuccess) {
		echo json_encode(array("statusCode"=>200)); // 200 : Register Success
	} else if(!$isSessioned) {
		echo json_encode(array("statusCode"=>201)); // 201 : No Sessioned Appointees
	} else {
		echo json_encode(array("statusCode"=>202)); // 202 : Register Error (Email is taken)
	}

?>