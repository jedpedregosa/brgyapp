<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");

    if(!$is_resdnt_lgn) {
        header("Location: ../../logout");
        exit();
    }

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
        && isset($_POST["purpose"])
        && isset($_FILES["idCardPic"])
        && isset($_POST["extend-purpose"])
        && isset($_FILES["profilePic"]);

    if(!$post_result) {
        goPrev();
    }

    $file_upload_success = true;
    $file_loc;

    $current_time = date("Y-m-d H:i:s");
    $clearance_id = time();

    if($_FILES["idCardPic"]['size'] > 0 && $_FILES["profilePic"]['size'] > 0) {
        $file_dp = $_FILES["profilePic"];
        $file_id = $_FILES["idCardPic"];

        if(isImageValid($file_dp) && isImageValid($file_id)) {
            $unique_file_name = "RESIDENT_CLEARANCE-" . hash("sha256", $clearance_id . $current_time);
            $file_dir = '../../../FILE_STORAGE/BRGY_CLEARANCE/';
            $file_loc = $file_dir . $unique_file_name;

            if(!is_dir($file_loc)) {
                if(mkdir($file_loc)) {
                    $_file_dp = tempnam_sfx($file_loc, "FILE_PROFILE");
                    $_file_id = tempnam_sfx($file_loc, "FILE_ID");
    
                    $file_upload_success = move_uploaded_file($file_dp['tmp_name'], $_file_dp)
                        && move_uploaded_file($file_id['tmp_name'], $_file_id);
                } else {
                    goPrev();
                }  
            } else {
                goPrev();
            }
        } else {
            goPrev();
        }
    } else {
        goPrev();
    }

    $clearance_details = [
        $clearance_id,
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
        ($_POST["purpose"] == "other") ? $_POST["extend-purpose"] : $_POST["purpose"],
        $current_time
    ];

    $clearance_stmt = "INSERT INTO tblClearance (id, fName, mName, lName, sffx, civStat, ctznshp, 
        bDate, sex, hNum, stName, contact, email, fbName, voter, purpose, sysTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if($file_upload_success) {
        if(insertStatement($clearance_stmt, $clearance_details)) {
            goPrev(100);
        }
    }

    goPrev();

    function goPrev($result = 101) {
        $_SESSION["req_response_type"] = $result;
    
        header("Location: ../../e-services/barangay-clearance");
        exit();
    }

    // Other
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
