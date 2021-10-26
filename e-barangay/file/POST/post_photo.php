<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(isset($_GET["p_id"]) && isset($_GET["type"])) {
        if($_GET["type"] == "view1") {
            $file_dir = "../../FILE_STORAGE/BRGY_POST_UPD/";
            $file_loc = $file_dir . "POST-" . hash("sha256", $_GET["p_id"]) . "/FILE_POST_PHOTO.tmp";

            $file_type = selectStatement("c", "SELECT anncmntHasPic FROM tblAnnouncements WHERE anncmntId = ?", [$_GET["p_id"]]);

            if($file_type["req_result"]) {
                if(count($file_type["req_val"]) > 0) {
                    $mime_type = $file_type["req_val"];

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
                        header("Content-Type: " . $mime_type);
                        header('Content-Length: ' . filesize($file_loc));

                        readfile($file_loc);
                        exit();
                       
                    }
                    
                }
            }
        } else if($_GET["type"] == "view2") {
            $file_dir = "../../FILE_STORAGE/BRGY_HLTH_UPD/";
            $file_loc = $file_dir . "UPD-" . hash("sha256", $_GET["p_id"]) . "/FILE_H-UPD_PHOTO.tmp";

            $file_type = selectStatement("c", "SELECT updateHasPic FROM tblHealthUpdates WHERE updateId = ?", [$_GET["p_id"]]);

            if($file_type["req_result"]) {
                if(count($file_type["req_val"]) > 0) {
                    $mime_type = $file_type["req_val"];

                    if(is_file($file_loc)) {
                        while (ob_get_level()) {
                            ob_end_clean();
                        }
                        flush();

                        header('Content-Description: File Transfer');
                        header('Content-Disposition: attachment');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($file_loc));
                        header("Content-Type: " . $mime_type);

                        readfile($file_loc);
                        exit();
                       
                    }
                    
                }
            }
        }
    }
?>