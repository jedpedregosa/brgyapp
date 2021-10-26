<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        echo json_encode(array("req_pro_status"=>102));
        exit();
    }

    if(!IS_AJAX) {
        header("Location: ../../home");
    }

    if(isset($_POST["id_rows"]) && isset($_POST["type"])) {
        $all_rows = json_decode($_POST["id_rows"]);
        $result = true;
        
        if($_POST["type"] == "1") {
            foreach($all_rows as $id) {
                $result = $result && updateStatement("UPDATE tblResident_auth SET resValid = 1 WHERE resUname = ?", $id);
            }
        } else if($_POST["type"] == "2") {
            foreach($all_rows as $id) {
                $result = $result && updateStatement("DELETE FROM tblResident_auth WHERE resUname = ?", $id);
                $result = $result && updateStatement("DELETE FROM tblResident WHERE resUname = ?", $id);
            }
        }
         
        if($result) {
            echo json_encode(array("req_pro_status"=>100));
            exit();
        }
    }
    
    echo json_encode(array("req_pro_status"=>101));
?>