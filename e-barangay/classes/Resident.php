<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Queries.php");

    function checkResidentValidity($username) {
        
        $stmt_uname = selectStatement("c", "SELECT COUNT(*) FROM tblResident_auth WHERE resUname = ?", $username);
        $stmt_email = selectStatement("c", "SELECT COUNT(*) FROM tblResident_auth WHERE resEmail = ?", $username);
        $stmt_cntct = selectStatement("c", "SELECT COUNT(*) FROM tblResident_auth WHERE resContact = ?", $username);

        if(!($stmt_uname["req_result"] && $stmt_email["req_result"] && $stmt_cntct["req_result"])) {
            return false;
        }

        if($stmt_uname["req_val"] || $stmt_email["req_val"] || $stmt_cntct["req_val"]) {
            return false;
        } else {
            return true;
        }
    }

    function doesResExistAndValid($username) {
        $result = selectStatement("c", 
            "SELECT COUNT(*) FROM tblResident_auth WHERE (resUname = ? OR resEmail = ? OR resContact = ?) AND resValid = 1",
            [$username, $username, $username]);

        if($result["req_result"]) {
            if($result["req_val"]) {
                return true;
            }
        }

        return false;
    }

    function residentLastPassChng($username) {
        $result = selectStatement("c",
            "SELECT resPwordChng FROM tblResident_auth WHERE resUname = ? OR resEmail = ? OR resContact = ?", 
            [$username, $username, $username]);

        if($result["req_result"]) {
            if($result["req_val"]) {
                return $result["req_val"];
            }
        }

        return false;
    }

    function getResidentUsername($username) {
        $result = selectStatement("c", "SELECT resUname FROM tblResident_auth WHERE resEmail = ? OR resContact = ?", [$username, $username]);

        if($result["req_result"]) {
            if($result["req_val"]) {
                return $result["req_val"];
            }
        }

        return false;
    }

?>