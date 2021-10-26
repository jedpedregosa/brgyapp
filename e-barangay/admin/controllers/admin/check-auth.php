<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Admin.php");

    $post_req = isset($_POST["sbmt-admn-lgn"]) && isset($_POST["lgnUname"]) && isset($_POST["lgnPword"]);
    if(!$post_req) {
        goPrev();
    }

    $uname = $_POST["lgnUname"];
    $pword = $_POST["lgnPword"];

    session_name("b_cid");
    session_start();

    if(!doesAdminExist($uname)) {
        goPrev(101);
    }

    // Authentication Check
    
    # Check if admin is blocked

    $hour_ago = time() - 60 * 60;

    $total_attmps = selectStatement("c", "SELECT COUNT(*) FROM tblAdmin_attmp WHERE admnUname = ? AND attmpStmp > ?", [$uname, $hour_ago]);
    
    if($total_attmps["req_result"]) {
        if(admin_max_attempt < $total_attmps["req_val"]) {
            goPrev(102);
        }
    } else {
        goPrev();
    }


    # Get the salt string
    $admn_gString = selectStatement("c", "SELECT admnGString FROM tblAdmin_auth WHERE admnUname = ? OR admnEmail = ?", [$uname, $uname]);

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
        "SELECT COUNT(*) FROM tblAdmin_auth WHERE (admnUname = ? OR admnEmail = ?) AND admnPword = ?",
        [$uname, $uname, $fnl_pwrd]);

    if($auth_result["req_result"]) {
        if($auth_result["req_val"] > 0) {
            $del_attmps = deleteStatement("DELETE FROM tblAdmin_attmp WHERE admnUname = ?", [$uname]);

            if(!$del_attmps) {
                goPrev();
            }

            # Get the latest password change
            $last_pass_chng = adminLastPassChng($uname);

            $_SESSION["admn_sess_loggedin"] = true;
            $_SESSION["admn_sess_uname"] = $uname;
            $_SESSION["admn_sess_tmeout"] = time() + 60 * 15; # Session expires every 15 min.
            $_SESSION["admn_sess_pwrdchng"] = $last_pass_chng;

            header("Location: ../../home");
            exit();

        } else {
            $insrt_attmp = insertStatement(
                    "INSERT INTO tblAdmin_attmp (admnUname, attmpStmp, attmpIpAdd) VALUES (?, ?, ?)",
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
        $_SESSION["res_admin_type"] = $result;
        header("Location: ../../login");
        exit();
    }
?>