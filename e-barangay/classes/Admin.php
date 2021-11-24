<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Queries.php");

    function doesAdminExist($username) {
        $result = selectStatement("c", "SELECT COUNT(*) FROM tblAdmin_auth WHERE admnUname = ? OR admnEmail = ?", [$username, $username]);

        if($result["req_result"]) {
            if($result["req_val"]) {
                return true;
            }
        }

        return false;
    }

    function checkAdminValidity($username) {
        
        $stmt_uname = selectStatement("c", "SELECT COUNT(*) FROM tblAdmin_auth WHERE admnUname = ?", $username);
        $stmt_email = selectStatement("c", "SELECT COUNT(*) FROM tblAdmin_auth WHERE admnEmail = ?", $username);

        if(!($stmt_uname["req_result"] && $stmt_email["req_result"])) {
            return false;
        }

        if($stmt_uname["req_val"] || $stmt_email["req_val"]) {
            return false;
        } else {
            return true;
        }
    }

    function adminLastPassChng($username) {
        $result = selectStatement("c", "SELECT admnPwordChng FROM tblAdmin_auth WHERE admnUname = ? OR admnEmail = ?", [$username, $username]);

        if($result["req_result"]) {
            if($result["req_val"]) {
                return $result["req_val"];
            }
        }

        return false;
    }

    function getAdminUsername($email) {
        $result = selectStatement("c", "SELECT admnUname FROM tblAdmin_auth WHERE admnEmail = ?", [$email]);

        if($result["req_result"]) {
            if($result["req_val"]) {
                return $result["req_val"];
            }
        }

        return false;
    }
?>