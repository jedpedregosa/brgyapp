<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Resident.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Module.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Posts.php");
    
    session_name("b_cid");
    session_start();

    $resdnt_uid;
    $is_resdnt_lgn = false;

    if(isset($_SESSION["resdnt_sess_loggedin"])) {
        $is_valid = isset($_SESSION["resdnt_sess_uname"])
            && isset($_SESSION["resdnt_sess_tmeout"])
            && isset($_SESSION["resdnt_sess_pwrdchng"]);
        
        if($is_valid) {
            
            if($_SESSION["resdnt_sess_tmeout"] > time()) {
                $temp_resdnt_uid = $_SESSION["resdnt_sess_uname"];

                $test_resdnt_uid = getResidentUsername($temp_resdnt_uid);
                
                $resdnt_uid = $test_resdnt_uid ? $test_resdnt_uid : $temp_resdnt_uid;
                
                if($_SESSION["resdnt_sess_pwrdchng"] == residentLastPassChng($resdnt_uid)) {
                    $_SESSION["resdnt_sess_tmeout"] = time() + 60 * 15; # Session expires every 15 min.
                    $is_resdnt_lgn = true;
                } 
            } else {
                # To logout
            }
            
        }
    }
?>