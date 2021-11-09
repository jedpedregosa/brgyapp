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
        
        if($_POST["type"] == "1") {                 # Residents Accepted
            foreach($all_rows as $id) {
                $result = $result && updateStatement("UPDATE tblResident_auth SET resValid = 1 WHERE resUname = ?", $id);
            }
        } else if($_POST["type"] == "2") {          # Resident Record Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblResident_auth WHERE resUname = ?", $id);
                $result = $result && updateStatement("DELETE FROM tblResident WHERE resUname = ?", $id);
            }
        } else if($_POST["type"] == "3") {          # Donation Record Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblDonation WHERE donationId = ?", $id);
            }
        } else if($_POST["type"] == "4") {          # Covid Info Move
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("UPDATE tblCovidInfo SET covStatus = covStatus + 1 WHERE infoId = ? AND covStatus < 4", $id);
            }
        } else if($_POST["type"] == "5") {          # Covid Info Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblCovidInfo WHERE infoId = ?", $id);
            }
        } else if($_POST["type"] == "6") {          # Blotter Report Move
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("UPDATE tblBlotterReport SET blotterStatus = blotterStatus + 1 WHERE blotterId = ?", $id);
            }
        } else if($_POST["type"] == "7") {          # Blotter Report Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblBlotterReport WHERE blotterId = ?", $id);
            }
        } 
         
        if($result) {
            echo json_encode(array("req_pro_status"=>100));
            exit();
        }
    }
    
    echo json_encode(array("req_pro_status"=>101));
?>