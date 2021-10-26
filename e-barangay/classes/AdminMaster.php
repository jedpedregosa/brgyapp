<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Admin.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Module.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Posts.php");
    
    session_name("b_cid");
    session_start();

    $admn_uid;
    $is_admn_lgn = false;

    if(isset($_SESSION["admn_sess_loggedin"])) {
        $is_valid = isset($_SESSION["admn_sess_uname"])
            && isset($_SESSION["admn_sess_tmeout"])
            && isset($_SESSION["admn_sess_pwrdchng"]);
        
        if($is_valid) {
            
            if($_SESSION["admn_sess_tmeout"] > time()) {
                $temp_admn_uid = $_SESSION["admn_sess_uname"];

                $test_admn_uid = getAdminUsername($temp_admn_uid);
                
                $admn_uid = $test_admn_uid ? $test_admn_uid : $temp_admn_uid;
                
                if($_SESSION["admn_sess_pwrdchng"] == adminLastPassChng($admn_uid)) {
                    $_SESSION["admn_sess_tmeout"] = time() + 60 * 15; # Session expires every 15 min.
                    $is_admn_lgn = true;
                } 
            } else {
                # To logout
            }
            
        }
    }


?>