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
        } else if($_POST["type"] == "8") {          # Clearance Completed
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("UPDATE tblClearance SET cStatus = cStatus + 1 WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "9") {          # Clearance Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblClearance WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "10") {          # ID Request Completed
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("UPDATE tblIdRequest SET rStatus = rStatus + 1 WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "11") {          # ID Request Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblIdRequest WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "12") {          # Indigency Request Completed
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("UPDATE tblIndigency SET rStatus = rStatus + 1 WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "13") {          # Indigency Request Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblIndigency WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "14") {          # Burial Cert Request Completed
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("UPDATE tblBurialRequest SET rStatus = rStatus + 1 WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "15") {          # Burial Cert Request Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblBurialRequest WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "16") {          # Employment Cert Request Completed
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("UPDATE tblEmpForm SET rStatus = rStatus + 1 WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "17") {          # Employment Cert Request Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblEmpForm WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "18") {          # Travel Cert Request Completed
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("UPDATE tblTravelRequest SET rStatus = rStatus + 1 WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "19") {          # Travel Cert Request Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblTravelRequest WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "20") {          # Proof of Res Request Completed
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("UPDATE tblResProof SET rStatus = rStatus + 1 WHERE id = ?", $id);
            }
        } else if($_POST["type"] == "21") {          # Proof of Res Request Deleted
            foreach($all_rows as $id) {   
                $result = $result && updateStatement("DELETE FROM tblResProof WHERE id = ?", $id);
            }
        } 
         
         
         
        if($result) {
            echo json_encode(array("req_pro_status"=>100));
            exit();
        }
    }
    
    echo json_encode(array("req_pro_status"=>101));
?>