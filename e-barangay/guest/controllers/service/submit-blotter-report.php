<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");

    if(!$is_resdnt_lgn) {
        header("Location: ../../logout");
        exit();
    }

    $post_result = isset($_POST["firstname"])
        && isset($_POST["lastname"])
        && isset($_POST["alias"])
        && isset($_POST["suffix"])
        && isset($_POST["contact"])
        && isset($_POST["email"])
        && isset($_POST["ctzn"])
        && isset($_POST["age"])
        && isset($_POST["Sex"])
        && isset($_POST["HouseNum"])
        && isset($_POST["street"])
        && isset($_POST["dateoc"])
        && isset($_POST["incident"])
        && isset($_POST["susfirstname"])
        && isset($_POST["suslastname"])
        && isset($_POST["susalias"])
        && isset($_POST["sussuffix"])
        && isset($_POST["susage"])
        && isset($_POST["susSex"])
        && isset($_POST["susHouseNum"])
        && isset($_POST["susstreet"])
        && isset($_POST["reason"])
        && isset($_FILES["idfile"]);

    if(!$post_result) {
        goPrev();
    }

    $file_upload_success = true;

    $current_time = date("Y-m-d H:i:s");
    $blotter_id = time();
    $id_file;

    if(isset($_FILES["idfile"])) {
        if($_FILES["idfile"]['size'] > 0) {
            $file_upload = $_FILES["idfile"];
            $has_file = isImageValid($file_upload);

            if($has_file) {
                $unique_file_name = "BLOTTER_REPORT-" . hash("sha256", $blotter_id . $current_time);
    
                $file_dir = '../../../FILE_STORAGE/BLOTTER_FILES/';
    
                if(is_dir($file_dir)) {
                    $_file = tempnam_sfx($file_dir, $unique_file_name);
    
                    $file_upload_success = move_uploaded_file($file_upload['tmp_name'], $_file);
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

    $blotter_details = [
        $blotter_id,
        $_POST["firstname"],
        $_POST["lastname"],
        $_POST["alias"],
        $_POST["suffix"],
        $_POST["contact"],
        $_POST["email"],
        $_POST["ctzn"],
        $_POST["age"],
        $_POST["Sex"],
        $_POST["HouseNum"],
        $_POST["street"],
        $_POST["dateoc"],
        $_POST["incident"],
        $_POST["susfirstname"],
        $_POST["suslastname"],
        $_POST["susalias"],
        $_POST["sussuffix"],
        $_POST["susage"],
        $_POST["susSex"],
        $_POST["susHouseNum"],
        $_POST["susstreet"],
        $_POST["reason"],
        USER_IP,
        $current_time
    ];

    $blotter_details_stmt = "INSERT INTO tblBlotterReport (blotterId, fName, lName, alias, suffix, contact, email, 
        ctzn, age, sex, hNum, street, dateCrime, incident, susFname, susLname, susAlias, susSuffix, susAge, susSex, susHnum,
        susStreet, reason, userIp, sysTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if($file_upload_success) {
        if(insertStatement($blotter_details_stmt, $blotter_details)) {
            goPrev(100);
        }
    }

    goPrev();

    function goPrev($result = 101) {
        $_SESSION["report_response_type"] = $result;
    
        header("Location: ../../e-services/barangay-blotter-report");
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