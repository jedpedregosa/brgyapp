<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Resident.php");

    $post_req = isset($_POST["sbmt-gst-lgn"]) && isset($_POST["lgnUname"]) && isset($_POST["lgnPword"]);
    if(!$post_req) {
        goPrev();
    }

    $uname = $_POST["lgnUname"];
    $pword = $_POST["lgnPword"];

    session_name("b_cid");
    session_start();

    # Check if resident is existing and validated

    if(!doesResExistAndValid($uname)) {
        goPrev(101);
    }

    // Authentication Check
    
    # Check if resident is blocked

    $hour_ago = time() - 60 * 30;

    $total_attmps = selectStatement("c", "SELECT COUNT(*) FROM tblResident_attmp WHERE resUname = ? AND attmpStmp > ?", [$uname, $hour_ago]);
    
    if($total_attmps["req_result"]) {
        if(resident_max_attempt < $total_attmps["req_val"]) {
            goPrev(102);
        }
    } else {
        goPrev();
    }


    # Get the salt string
    $admn_gString = selectStatement("c", 
        "SELECT resGString FROM tblResident_auth WHERE resUname = ? OR resEmail = ? OR resContact = ?",
        [$uname, $uname, $uname]);

    if($admn_gString["req_result"]) {
        $admn_gString = $admn_gString["req_val"];

        if(!$admn_gString) {
            goPrev();
        }
    } else {
        goPrev();
    }

    # Authenticate admin
    $fnl_pwrd = hash("sha256", $pword . $admn_gString);

    $auth_result = selectStatement("c", 
        "SELECT COUNT(*) FROM tblResident_auth WHERE (resUname = ? OR resEmail = ? OR resContact = ?) AND resPword = ?",
        [$uname, $uname, $uname, $fnl_pwrd]);

    if($auth_result["req_result"]) {
        if($auth_result["req_val"] > 0) {
            $del_attmps = deleteStatement("DELETE FROM tblResident_attmp WHERE resUname = ?", [$uname]);

            if(!$del_attmps) {
                goPrev();
            }

            # Get the latest password change
            $last_pass_chng = residentLastPassChng($uname);

            $_SESSION["resdnt_sess_loggedin"] = true;
            $_SESSION["resdnt_sess_uname"] = $uname;
            $_SESSION["resdnt_sess_tmeout"] = time() + 60 * 1200; # Session expires every 10 hours.
            $_SESSION["resdnt_sess_pwrdchng"] = $last_pass_chng;

            header("Location: ../../home");
            exit();

        } else {
            $insrt_attmp = insertStatement(
                    "INSERT INTO tblResident_attmp (resUname, attmpStmp, attmpIpAdd) VALUES (?, ?, ?)",
                    [$uname, time(), USER_IP]
                );
    
            if(!$insrt_attmp) {
                goPrev();
            }
            goPrev(101);
        }
    } else {
        goPrev();
    }

    function goPrev($result = 103) {
        $_SESSION["res_resdnt_type"] = $result;
        header("Location: ../../login");
        exit();
    }
?>