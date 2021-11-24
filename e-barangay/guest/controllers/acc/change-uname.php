<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");
    
    if(!$is_resdnt_lgn) {
        header("Location: ../../logout");
        exit();    
    }

    if(!(isset($_POST["Uname"]))) {
        goPrev();
    }

    $username = $_POST["Uname"];
    if(checkResidentValidity($username)) {
        $time_sql = selectStatement("c", "SELECT sysTime FROM tblResident WHERE resUname = ?", [$resdnt_uid]);

        if($time_sql["req_result"]) {
            $sys_time = $time_sql["req_val"];

            $storage_dir = '../../../FILE_STORAGE/RESIDENT_FILES/';
            $old_file_name = hash("sha256", $resdnt_uid . $sys_time);
            $new_file_name = hash("sha256", $username . $sys_time);

            $old_file_dir = $storage_dir . "RESIDENT-" . $old_file_name;
            $new_file_dir = $storage_dir . "RESIDENT-" . $new_file_name;

            if(is_dir($old_file_dir)) {
                if(!rename($old_file_dir, $new_file_dir)) {
                    goPrev();
                }
            } else {
                goPrev();
            }
        } else {
            goPrev();
        }
        

        $result = updateStatement("UPDATE tblResident_auth SET resUname = ? WHERE resUname = ?", [$username, $resdnt_uid])
            && updateStatement("UPDATE tblResident SET resUname = ? WHERE resUname = ?", [$username, $resdnt_uid]);
        if($result) {
            $_SESSION["resdnt_sess_uname"] = $username;
            goPrev(100);
        }
        goPrev();
    } else {
        goPrev();
    }

    function goPrev($code = 101) {
        $_SESSION["res_update_set"] = $code;
        header("Location: ../../e-services/view-profile");
        exit();
    }
?>