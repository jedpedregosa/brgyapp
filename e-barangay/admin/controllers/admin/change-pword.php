<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../../logout");
        exit();
    }

    if(!(isset($_POST["Pword"]) && isset($_POST["curPword"]))) {
        goPrev();
    }

    $c_pword = $_POST["curPword"];
    $n_pword = $_POST["Pword"];

    $current_auth = selectStatement("f", "SELECT * FROM tblAdmin_auth WHERE admnUname = ?", [$admn_uid]);

    if($current_auth["req_result"]) {
        if($current_auth["req_val"]) {
            $auth_val = $current_auth["req_val"];

            $c_hash = hash("sha256", $c_pword . $auth_val["admnGString"]);

            if($c_hash == $auth_val["admnPword"]) {
                $generated_string = generateRandomString(20);
                $n_hash = hash("sha256", $n_pword . $generated_string);

                $update_res = updateStatement("UPDATE tblAdmin_auth SET admnPword = ?, admnGString = ?, admnPwordChng = ? WHERE admnUname = ?", [$n_hash, $generated_string, time(), $admn_uid]);
           
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
        $_SESSION["admn_update_res"] = $code;
        header("Location: ../../e-services/barangay-profile");
        exit();
    }
?>