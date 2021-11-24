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
        && isset($_POST["bPlace"])
        && isset($_POST["weight"])
        && isset($_POST["height"])
        && isset($_POST["idNum"])
        && isset($_POST["voterId"])
        && isset($_POST["nName"])
        && isset($_POST["nContact"])
        && isset($_POST["nAddress"])
        && isset($_FILES["idCardPic"])
        && isset($_FILES["profilePic"]);

    if(!$post_result) {
        goPrev();
    }

    $file_upload_success = true;
    $file_loc;

    $req_id_time = date("Y-m-d H:i:s");
    $req_id = time();

    if($_FILES["idCardPic"]['size'] > 0 && $_FILES["profilePic"]['size'] > 0) {
        $file_dp = $_FILES["profilePic"];
        $file_id = $_FILES["idCardPic"];

        if(isImageValid($file_dp) && isImageValid($file_id)) {
            $unique_file_name = "RESIDENT_ID_REQ-" . hash("sha256", $req_id . $req_id_time);
            $file_dir = '../../../FILE_STORAGE/BRGY_ID_REQUEST/';
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

    $id_details = [
        $req_id,
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
        $_POST["bPlace"],
        $_POST["weight"],
        $_POST["height"],
        $_POST["idNum"],
        $_POST["voterId"],
        $_POST["nName"],
        $_POST["nContact"],
        $_POST["nAddress"],
        $req_id_time
    ];

    $id_stmt = "INSERT INTO tblIdRequest (id, fName, mName, lName, sffx, civStat, ctznshp, 
        bDate, sex, hNum, stName, contact, email, fbName, voter, bPlace, weight, height, idNum, voterId, nName, nContact, nAddress, sysTime) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if($file_upload_success) {
        if(insertStatement($id_stmt, $id_details)) {
            goPrev(100);
        }
    }

    goPrev();

    function goPrev($result = 101) {
        $_SESSION["req_response_type"] = $result;
    
        header("Location: ../../e-services/barangay-id-form");
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
