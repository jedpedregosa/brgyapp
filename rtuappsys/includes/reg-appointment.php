<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    
    $conn = connectDb();
    
    $lname=$_POST['lname'];
    $fname=$_POST['fname'];
	$email=$_POST['email'];
	$phone=$_POST['phone']; 

    $visitorID = "VSTOR-" . createVisitorId();

	$stmt = $conn -> prepare("INSERT INTO tbl_visitor (vstor_id, vstor_lname, vstor_fname, vstor_contact, vstor_email)
    VALUES (:id, :lname, :fname, :phone, :email)");
	$stmt-> bindParam(':id', $visitorID);
	$stmt-> bindParam(':lname', $lname);
	$stmt-> bindParam(':fname', $fname);
	$stmt-> bindParam(':phone', $phone);
	$stmt-> bindParam(':email', $email);
	
    if ($stmt->execute()) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}

?>