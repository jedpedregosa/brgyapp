<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    
    $conn = connectDb();

    /*
    $lname=$_POST['lname'];
    $fname=$_POST['fname'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];*/
    $lname="TEST";
    $fname="TEST";
	$email="TEST";
	$phone="TEST";
    $test = "1";

	$sql = "INSERT INTO 'tbl_visitor' ( 'vstor_id', 'vstor_lname', 'vstor_fname', 'vstor_contact', 'vstor_email') 
	VALUES ('$test','$lname','$fname','$phone','$email')";
	
    /*if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}*/
    mysqli_query($conn, $sql);
    mysqli_connect_error();
	//mysqli_close($conn);
?>