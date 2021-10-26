<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(isset($_GET["p_id"]) && isset($_GET["type"])) {
        if($_GET["type"] == "view1") {
            $file_dir = "../../FILE_STORAGE/BRGY_POST_UPD/";
            $file_loc = $file_dir . "POST-" . hash("sha256", $_GET["p_id"]) . "/FILE_POST_DOCU.tmp";

            $file_type = selectStatement("f", "SELECT anncmntHasFile, anncmntFname FROM tblAnnouncements WHERE anncmntId = ?", [$_GET["p_id"]]);

            if($file_type["req_result"]) {
                if(count($file_type["req_val"]) > 0) {
                    $mime_type = $file_type["req_val"];

                    if(is_file($file_loc)) {

                        header('Content-Description: File Transfer');
                        header('Content-Type: ' . $mime_type["anncmntHasFile"]);
                        header("Content-Disposition: attachment; filename=\"" . $mime_type["anncmntFname"] . "\";");
                        header('Content-Transfer-Encoding: binary');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($file_loc));
                        ob_clean();
                        flush();
                        readfile($file_loc); //showing the path to the server where the file is to be download
                        exit;  
                    }
                    
                }  
            }
        } else if($_GET["type"] == "view2") {
            $file_dir = "../../FILE_STORAGE/BRGY_HLTH_UPD/";
            $file_loc = $file_dir . "UPD-" . hash("sha256", $_GET["p_id"]) . "/FILE_H-UPD_DOCU.tmp";

            $file_type = selectStatement("f", "SELECT updateHasFile, updateFname FROM tblHealthUpdates WHERE updateId = ?", [$_GET["p_id"]]);

            if($file_type["req_result"]) {
                if(count($file_type["req_val"]) > 0) {
                    $mime_type = $file_type["req_val"];

                    if(is_file($file_loc)) {

                        header('Content-Description: File Transfer');
                        header('Content-Type: ' . $mime_type["updateHasFile"]);
                        header("Content-Disposition: attachment; filename=\"" . $mime_type["updateFname"] . "\";");
                        header('Content-Transfer-Encoding: binary');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($file_loc));
                        ob_clean();
                        flush();
                        readfile($file_loc); //showing the path to the server where the file is to be download
                        exit;  
                    }
                    
                }  
            }
        }
    }
?>