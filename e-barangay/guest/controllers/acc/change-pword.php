<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");
    
    if(!$is_resdnt_lgn) {
        header("Location: ../../logout");
        exit();    
    }

    if(!(isset($_POST["Pword"]) && isset($_POST["curPword"]))) {
        goPrev();
    }

    $c_pword = $_POST["curPword"];
    $n_pword = $_POST["Pword"];

    $current_auth = selectStatement("f", "SELECT * FROM tblResident_auth WHERE resUname = ?", [$resdnt_uid]);

    if($current_auth["req_result"]) {
        if($current_auth["req_val"]) {
            $auth_val = $current_auth["req_val"];

            $c_hash = hash("sha256", $c_pword . $auth_val["resGString"]);

            if($c_hash == $auth_val["resPword"]) {
                $generated_string = generateRandomString(20);
                $n_hash = hash("sha256", $n_pword . $generated_string);

                $update_res = updateStatement("UPDATE tblResident_auth SET resPword = ?, resGString = ?, resPwordChng = ? WHERE resUname = ?", [$n_hash, $generated_string, time(), $resdnt_uid]);
           
                if($update_res) {
                    goPrev(200);
                } else {
                    goPrev();
                }
            } else {
                goPrev(201);
            }
        } else {
            goPrev();
        }
    } else {
        goPrev();
    }

    function goPrev($code = 202) {
        $_SESSION["res_update_set"] = $code;
        header("Location: ../../e-services/view-profile");
        exit();
    }
?>