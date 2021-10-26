<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../../logout");
        exit();
    }

    $post_id = time();
    $unique_file_name = hash("sha256", $post_id);
    $current_time = date("Y-m-d H:i:s");
    $post_msg;

    $post_req = isset($_POST["update_text_msg"])
        && isset($_FILES["file_pht"])
        && isset($_FILES["file_doc"]);

    if($post_req) {
        $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6>';
        $allowedTags.='<li><ol><ul><span><div><br><ins><del>';
        $receivedData = $_POST["update_text_msg"];
        $post_msg = strip_tags(stripslashes($receivedData),$allowedTags);
    }

    if(isset($_GET["type"])) {
        if($_GET["type"] == "anncmnt") {            
            if($post_req) {
                $storage_dir = '../../../FILE_STORAGE/BRGY_POST_UPD/';
                $hasPhoto = 0;
                $hasDoc = 0;
                $docName = 0;
                $temp_file;
                $temp_photo;

                if(file_exists($_FILES['file_pht']['tmp_name']) || is_uploaded_file($_FILES['file_pht']['tmp_name'])) {
                    if(isImageValid($_FILES["file_pht"])) {
                        $file_dir = $storage_dir . "POST-" . $unique_file_name;

                        if(!is_dir($file_dir)) {
                            if(!mkdir($file_dir)) {
                                goPrev();
                            }
                        } else {
                            goPrev(); //Error Message
                        }

                        $temp_photo = tempnam_sfx($file_dir, "FILE_POST_PHOTO");
                        $file_upload_success = move_uploaded_file($_FILES["file_pht"]['tmp_name'], $temp_photo);

                        if(!$file_upload_success) {
                            goPrev();
                        }

                        $hasPhoto = $_FILES["file_pht"]["type"];
                    } else {
                        goPrev();
                    }
                }

                if(file_exists($_FILES['file_doc']['tmp_name']) || is_uploaded_file($_FILES['file_doc']['tmp_name'])) {
                    if(isFileValid($_FILES["file_doc"])) {
                        $file_dir = $storage_dir . "POST-" . $unique_file_name;

                        if(!is_dir($file_dir)) {
                            if(!mkdir($file_dir)) {
                                goPrev();
                            }
                        }

                        $temp_file = tempnam_sfx($file_dir, "FILE_POST_DOCU");
                        $file_upload_success = move_uploaded_file($_FILES["file_doc"]['tmp_name'], $temp_file);

                        if(!$file_upload_success) {
                            goPrev();
                        }

                        $hasDoc = $_FILES["file_doc"]["type"];
                        $docName = (string)$_FILES["file_doc"]["name"];
                    } else {
                        goPrev();
                    }
                }

                $inset_string = "INSERT INTO tblAnnouncements (anncmntId, anncmntMsg, anncmntHasPic, anncmntHasFile, anncmntFname, sysTime) VALUES (?, ?, ?, ?, ?, ?)";
                $insertPost = insertStatement($inset_string, [$post_id, $post_msg, $hasPhoto, $hasDoc, $docName, $current_time]);

                if($insertPost) {
                    header("Location: ../../home");
                    exit();
                } else {
                    if($temp_photo) {
                        unlink($temp_photo);
                    }
                    
                    if($temp_file) {
                        unlink($temp_file);
                    }        
                
                    if(is_dir($file_dir)) {
                        rmdir($file_dir);
                    }
                    goPrev();
                }
            } else {
                goPrev();
            }
        } else if($_GET["type"] == "hlthpdt") {
            if($post_req) {
                $storage_dir = '../../../FILE_STORAGE/BRGY_HLTH_UPD/';
                $hasPhoto = 0;
                $hasDoc = 0;
                $docName = 0;
                $temp_file;
                $temp_photo;

                if($_FILES["file_pht"]['size'] != 0) {
                    if(isImageValid($_FILES["file_pht"])) {
                        $file_dir = $storage_dir . "UPD-" . $unique_file_name;

                        if(!is_dir($file_dir)) {
                            if(!mkdir($file_dir)) {
                                goPrev();
                            }
                        } else {
                            goPrev(); //Error Message
                        }

                        $temp_photo = tempnam_sfx($file_dir, "FILE_H-UPD_PHOTO");
                        $file_upload_success = move_uploaded_file($_FILES["file_pht"]['tmp_name'], $temp_photo);

                        if(!$file_upload_success) {
                            goPrev();
                        }

                        $hasPhoto = $_FILES["file_pht"]["type"];
                    } else {
                        goPrev();
                    }
                }

                if($_FILES["file_doc"]['size'] != 0) {
                    if(isFileValid($_FILES["file_doc"])) {
                        $file_dir = $storage_dir . "UPD-" . $unique_file_name;

                        if(!is_dir($file_dir)) {
                            if(!mkdir($file_dir)) {
                                goPrev();
                            }
                        }

                        $temp_file = tempnam_sfx($file_dir, "FILE_H-UPD_DOCU");
                        $file_upload_success = move_uploaded_file($_FILES["file_doc"]['tmp_name'], $temp_file);

                        if(!$file_upload_success) {
                            goPrev();
                        }

                        $hasDoc = $_FILES["file_doc"]["type"];
                        $docName = (string)$_FILES["file_doc"]["name"];
                    } else {
                        goPrev();
                    }
                }

                $inset_string = "INSERT INTO tblHealthUpdates (updateId, updateMsg, updateHasPic, updateHasFile, updateFname, sysTime) VALUES (?, ?, ?, ?, ?, ?)";
                $insertPost = insertStatement($inset_string, [$post_id, $post_msg, $hasPhoto, $hasDoc, $docName, $current_time]);

                if($insertPost) {
                    header("Location: ../../home");
                    exit();
                } else {
                    if($temp_photo) {
                        unlink($temp_photo);
                    }
                    
                    if($temp_file) {
                        unlink($temp_file);
                    }        
                
                    if(is_dir($file_dir)) {
                        rmdir($file_dir);
                    }
                    goPrev();
                }
            } else {
                goPrev();
            }
        } else {
            goPrev();
        }
    } 

    function goPrev($result = 201) {
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            header("Location: ../../home");
        }
    
        exit();
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