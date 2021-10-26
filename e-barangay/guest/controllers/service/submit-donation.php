<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");

    $post_result = isset($_POST["txtPosition"])
        && isset($_POST["txtLname"])
        && isset($_POST["txtFname"])
        && isset($_POST["txtMi"])
        && isset($_POST["txtEmail"])
        && isset($_POST["txtContact"])
        && isset($_POST["txtHnum"])
        && isset($_POST["txtStName"])
        && isset($_POST["txtBrgy"])
        && isset($_POST["txtCity"])
        && isset($_POST["txtPcode"])
        && isset($_POST["txtType"]);

    if(!$post_result) {
        goPrev();
    }

    $file_upload_success = true;
    $has_file = false;

    $current_time = date("Y-m-d H:i:s");
    $donation_id = time();
    $donation_file;

    if(isset($_FILES["filePay"])) {
        if($_FILES["filePay"]['size'] > 0) {
            $file_upload = $_FILES["filePay"];
            $has_file = isImageValid($file_upload);

            if($has_file) {
                $unique_file_name = "DONATION-" . hash("sha256", $donation_id . $current_time);

                $file_dir = '../../../FILE_STORAGE/DONATION_FILES/';

                if(is_dir($file_dir)) {
                    $donation_file = tempnam_sfx($file_dir, $unique_file_name);

                    $file_upload_success = move_uploaded_file($file_upload['tmp_name'], $donation_file);
                } else {
                    goPrev();
                }
            }
        }
    }
    
    $donation_details = [
        $donation_id,
        $_POST["txtPosition"],
        $_POST["txtLname"],
        $_POST["txtFname"],
        $_POST["txtMi"],
        $_POST["txtEmail"],
        $_POST["txtContact"],
        $_POST["txtHnum"],
        $_POST["txtStName"],
        $_POST["txtBrgy"],
        $_POST["txtCity"],
        $_POST["txtPcode"],
        $_POST["txtType"],
        (!empty($_POST["txtDate"])) ? $_POST["txtDate"] : null,
        (!empty($_POST["txtTypeG"])) ? $_POST["txtTypeG"] : " ",
        (!empty($_POST["txtDateTrans"])) ? $_POST["txtDateTrans"] : null,
        (!empty($_POST["txtTypeP"])) ? $_POST["txtTypeP"] : " ",
        (!empty($_POST["txtAmount"])) ? $_POST["txtAmount"] : " ",
        (!empty($_POST["txtRemark"])) ? $_POST["txtRemark"] : " ",
        ($has_file) ? 1 : 0,
        USER_IP,
        $current_time
    ];

    $don_details_stmt = "INSERT INTO tblDonation (donationId, position, lName, fName, mInitial, email, 
        contact, hNumber, stName, brgy, city, pCode, donType, donDate, goodType, transDate, payType, payAmmnt, remark, hasFile, userIp, sysTime) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if($file_upload_success) {
        if(insertStatement($don_details_stmt, $donation_details)) {
            goPrev(100);
        }
    }
    
    if($has_file) {
        unlink($donation_file);
    }
    goPrev();

    function goPrev($result = 101) {
        $_SESSION["don_response_type"] = $result;
    
        header("Location: ../../donation");
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