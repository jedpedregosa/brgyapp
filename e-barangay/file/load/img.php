<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(isset($_GET["r_id"]) && isset($_GET["type"])) {
        $file_loc;
        $file_dir = "../../FILE_STORAGE/";

        if($_GET["type"] == "view1") {
            $file_loc = $file_dir . "RESIDENT_FILES/RESIDENT-" .  $_GET["r_id"] .  "/FILE_PHOTO.tmp";                             
        } else if($_GET["type"] == "view2") {
            $file_loc = $file_dir . "RESIDENT_FILES/RESIDENT-" .  $_GET["r_id"] .  "/FILE_IDFBACK.tmp";
        } else if($_GET["type"] == "view3") {
            $file_loc = $file_dir . "RESIDENT_FILES/RESIDENT-" .  $_GET["r_id"] .  "/FILE_SLFIE.tmp";
        } else if($_GET["type"] == "view4") {
            $file_loc = $file_dir . "RESIDENT_FILES/RESIDENT-" .  $_GET["r_id"] .  "/FILE_SIG.tmp";
        } else if($_GET["type"] == "view5") {
            $file_loc = $file_dir . "DONATION_FILES/DONATION-" .  $_GET["r_id"] .  ".tmp";
        } else if($_GET["type"] == "view6") {
            $file_loc = $file_dir . "BRGY_OFFICIAL/OFFICIAL-" .  $_GET["r_id"] .  ".tmp";
        } else if($_GET["type"] == "view7") {
            $file_loc = $file_dir . "BRGY_CLEARANCE/RESIDENT_CLEARANCE-" .  $_GET["r_id"] .  "/FILE_PROFILE.tmp";
        } else if($_GET["type"] == "view8") {
            $file_loc = $file_dir . "BRGY_CLEARANCE/RESIDENT_CLEARANCE-" .  $_GET["r_id"] .  "/FILE_ID.tmp";
        } else if($_GET["type"] == "view9") {
            $file_loc = $file_dir . "BRGY_ID_REQUEST/RESIDENT_ID_REQ-" .  $_GET["r_id"] .  "/FILE_PROFILE.tmp";
        } else if($_GET["type"] == "view10") {
            $file_loc = $file_dir . "BRGY_ID_REQUEST/RESIDENT_ID_REQ-" .  $_GET["r_id"] .  "/FILE_ID.tmp";
        } else if($_GET["type"] == "view11") {
            $file_loc = $file_dir . "BRGY_INDIGENCY/RESIDENT_INDIGENCY-" .  $_GET["r_id"] .  "/FILE_PROFILE.tmp";
        } else if($_GET["type"] == "view12") {
            $file_loc = $file_dir . "BRGY_INDIGENCY/RESIDENT_INDIGENCY-" .  $_GET["r_id"] .  "/FILE_ID.tmp";
        } else if($_GET["type"] == "view13") {
            $file_loc = $file_dir . "BRGY_BURIAL/RESIDENT_BURIAL_FILE-" .  $_GET["r_id"] .  "/FILE_PROFILE.tmp";
        } else if($_GET["type"] == "view14") {
            $file_loc = $file_dir . "BRGY_BURIAL/RESIDENT_BURIAL_FILE-" .  $_GET["r_id"] .  "/FILE_ID.tmp";
        } else if($_GET["type"] == "view15") {
            $file_loc = $file_dir . "BRGY_EMPLOYMENT/RESIDENT_EMPLOYMENT-" .  $_GET["r_id"] .  "/FILE_PROFILE.tmp";
        } else if($_GET["type"] == "view16") {
            $file_loc = $file_dir . "BRGY_EMPLOYMENT/RESIDENT_EMPLOYMENT-" .  $_GET["r_id"] .  "/FILE_ID.tmp";
        } else if($_GET["type"] == "view17") {
            $file_loc = $file_dir . "BRGY_TRAVEL/RESIDENT_TRAVEL_FILE-" .  $_GET["r_id"] .  "/FILE_PROFILE.tmp";
        } else if($_GET["type"] == "view18") {
            $file_loc = $file_dir . "BRGY_TRAVEL/RESIDENT_TRAVEL_FILE-" .  $_GET["r_id"] .  "/FILE_ID.tmp";
        } else if($_GET["type"] == "view19") {
            $file_loc = $file_dir . "BRGY_PROOF_OF_RES/RESIDENT_PROOF-" .  $_GET["r_id"] .  "/FILE_PROFILE.tmp";
        } else if($_GET["type"] == "view20") {
            $file_loc = $file_dir . "BRGY_PROOF_OF_RES/RESIDENT_PROOF-" .  $_GET["r_id"] .  "/FILE_ID.tmp";
        }

        if($file_loc) {
            if(is_file($file_loc)) {
                while (ob_get_level()) {
                    ob_end_clean();
                }
    
                flush();
    
                header('Content-Description: File Transfer');
                header('Content-Disposition: inline');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header("Content-Type: image/jpeg");
                header('Content-Length: ' . filesize($file_loc));
    
                readfile($file_loc);
                exit();     
            }
        }
    }
?>