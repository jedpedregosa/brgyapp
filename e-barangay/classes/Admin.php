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