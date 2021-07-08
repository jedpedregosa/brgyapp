<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    
    $conn = connectDb();
    
    $lname=$_POST['lname'];
    $fname=$_POST['fname'];
	$email=$_POST['email'];
	$phone=$_POST['phone']; 

    $visitorID = "VSTOR-" . createVisitorId();

	$sql = "INSERT INTO tbl_visitor (vstor_id, vstor_lname, vstor_fname, vstor_contact, vstor_email)
    VALUES ('$visitorID','$lname','$fname','$phone','$email')";
	
    if ($conn -> query($sql) == TRUE) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}

?>