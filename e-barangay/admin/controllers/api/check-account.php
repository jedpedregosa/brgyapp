<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Admin.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        echo json_encode(array("res_av_status"=>101));
        exit();
    }

    if(!IS_AJAX) {
       header("Location: ../../home");
    }

    if(isset($_POST["uniq_id"])) {
        $res;
        if(checkAdminValidity($_POST["uniq_id"])) {
            $res = 100;
        } else {
            $res = 101;
        }

        echo json_encode(array("res_av_status"=>$res));
    } 
?>