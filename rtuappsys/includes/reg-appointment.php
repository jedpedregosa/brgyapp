<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");

	// Check if from a page request
	if(isset($_POST['lname']) && isset($_POST['fname']) && isset($_POST['email']) && isset($_POST['phone'])) {
		$lname=$_POST['lname'];
		$fname=$_POST['fname'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];	
	} else {
		header("Location: ../main/rtuappsys.php");
	}

	$isSessioned = true;
	$isSuccess = false;

	session_name("id");
	session_start();

	if(!(isset($_SESSION["userId"]) && isset($_SESSION["uLname"]) && isset($_SESSION["uType"]))) {
        $isSessioned = false;
    }

	if($isSessioned) {
		$userId = $_SESSION["userId"];
		$userType = $_SESSION["uType"];

		$userData = [$userId, $lname, $fname, $email, $phone];

		if(doesUserExists($userId, $userType)) {

		} else {
			$isSuccess = insertUserData($userData, $userType);
		}
		
	}
    
    if ($isSuccess) {
		echo json_encode(array("statusCode"=>200));
	} else if($isSessioned) {
		echo json_encode(array("statusCode"=>201));
	}
	else {
		echo json_encode(array("statusCode"=>202));
	}

?>