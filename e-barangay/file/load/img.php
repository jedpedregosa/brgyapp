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