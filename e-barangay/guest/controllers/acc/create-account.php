<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Queries.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Module.php");

    session_name("b_cid");
    session_start();

    $post_result = isset($_POST["Fname"])
        && isset($_POST["Mname"])
        && isset($_POST["Lname"])
        && isset($_POST["Suffix"])
        && isset($_POST["CivStat"])
        && isset($_POST["Ctznshp"])
        && isset($_POST["Bdate"])
        && isset($_POST["Sex"])
        && isset($_POST["HouseNum"])
        && isset($_POST["StName"])
        && isset($_POST["Contact"])
        && isset($_POST["Email"])
        && isset($_POST["FbName"])
        && isset($_POST["Voter"])
        && isset($_POST["isPwd"])
        && isset($_POST["Uname"])
        && isset($_POST["Pword"]);

    $file_result = isset($_FILES["profilePic"])
        && isset($_FILES["idCardPic"])
        && isset($_FILES["selfiePic"]);

    if(!$post_result && !$file_result) {
        goPrev();
    }

    $all_files = [
        $_FILES["profilePic"],
        $_FILES["idCardPic"],
        $_FILES["selfiePic"]
    ];

    $are_files_valid = true;
    foreach($all_files as $file) {
        $are_files_valid = $are_files_valid && isUploadValid($file);
    }

    if(!$are_files_valid) {
        exit();
    }

    $current_time = date("Y-m-d H:i:s");

    $acc_details = [
        $_POST["Uname"],
        $_POST["Fname"], 
        $_POST["Mname"], 
        $_POST["Lname"], 
        $_POST["Suffix"], 
        $_POST["CivStat"], 
        $_POST["Ctznshp"],
        $_POST["Bdate"],
        $_POST["Sex"],
        $_POST["HouseNum"],
        $_POST["StName"],
        $_POST["Contact"],
        $_POST["Email"],
        $_POST["FbName"],
        $_POST["Voter"],
        ($_POST["isPwd"]) ? 1 : 0,
        $current_time
    ];

    $generated_string = generateRandomString(15);
    $gen_password = hash("sha256", $_POST["Pword"] . $generated_string);

    $acc_auth = [
        $_POST["Uname"],
        $_POST["Email"],
        $_POST["Contact"],
        $gen_password,
        $generated_string
    ];

    // For Files

    $storage_dir = '../../../FILE_STORAGE/RESIDENT_FILES/';
    $unique_file_name = hash("sha256", $acc_details[0] . $current_time);

    $file_dir = $storage_dir . "RESIDENT-" . $unique_file_name;


    if(!is_dir($file_dir)) {
		if(!mkdir($file_dir)) {
            goPrev();
        }
	} else {
        goPrev(); //Error Message
    }

    // All Files
    $photo_file = tempnam_sfx($file_dir, "FILE_PHOTO");
    $idcard_file = tempnam_sfx($file_dir, "FILE_IDFBACK");
    $selfie_file = tempnam_sfx($file_dir, "FILE_SLFIE"); 

    /* Upload the file to a secure directory with the new name and extension */
    $file_upload_success = move_uploaded_file($all_files[0]['tmp_name'], $photo_file)
        && move_uploaded_file($all_files[1]['tmp_name'], $idcard_file)
        && move_uploaded_file($all_files[2]['tmp_name'], $selfie_file);

    $res_details_stmt = "INSERT INTO tblResident (resUname, resFname, resMname, resLname, resSuffix, resCivStat, 
        resCitiznshp, resBdate, resSex, resHouseNum, resStName, resContact, resEmail, resFbName, resVoter, isPWD, sysTime) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $res_auth_stmt = "INSERT INTO tblResident_auth (resUname, resEmail, resContact, resPword, resGString)
        VALUES (?, ?, ?, ?, ?)";

    if($file_upload_success) {
        if(insertStatement($res_auth_stmt, $acc_auth) && insertStatement($res_details_stmt, $acc_details)) {
            goPrev(100);
        } 
    }
    
    // If above fails
    unlink($photo_file);
    unlink($idcard_file);
    unlink($selfie_file);
    unlink($sig_file);

    if(is_dir($file_dir)) {
        rmdir($file_dir);
    }

    goPrev();

    function goPrev($result = 101) {
        $_SESSION["req_response_type"] = $result;
        header("Location: ../../sign-up");
        exit();
    }

    function isUploadValid($file) {
        if($file['size'] > 10485760) { //10 MB (size is also in bytes)
            return false;
        }

        /* Process image with GD library */
        $verify_img = getimagesize($file['tmp_name']);

        /* Make sure the MIME type is an image */
        $pattern = "#^(image/)[^\s\n<]+$#i";
        
        if(!preg_match($pattern, $verify_img['mime'])){
            return false;
        }
        
        return true;
    }

    /* Generates random filename and extension */
    function tempnam_sfx($path, $file_name){
        do {
            $file = $path . "/" . $file_name . ".tmp";
            $fp = @fopen($file, 'x');
        }
        while(!$fp);

        fclose($fp);
        return $file;
    }

?>