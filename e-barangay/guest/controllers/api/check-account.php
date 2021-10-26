<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Resident.php");

    if(!IS_AJAX) {
       header("Location: ../../home");
    }

    if(isset($_POST["uniq_id"])) {
        $res;
        if(checkResidentValidity($_POST["uniq_id"])) {
            $res = 100;
        } else {
            $res = 101;
        }

        echo json_encode(array("res_av_status"=>$res));
    } 
?>