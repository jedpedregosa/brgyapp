<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Queries.php");

    function getAllPost() {
        $all_post = selectStatement("r", "SELECT * FROM tblAnnouncements ORDER BY sysTime DESC", null);

        if($all_post["req_result"]) {
            return $all_post["req_val"];
        } else {
            return false;
        }
    }

    function getAllHealthUpd() {
        $all_post = selectStatement("r", "SELECT * FROM tblHealthUpdates ORDER BY sysTime DESC", null);

        if($all_post["req_result"]) {
            return $all_post["req_val"];
        } else {
            return false;
        }
    }

    function getAllCovidInfo() {
        $all_post = selectStatement("f", "SELECT (SELECT COUNT(*) FROM tblCovidInfo) total, 
            (SELECT COUNT(*) FROM tblCovidInfo WHERE covStatus = 1) active, 
            (SELECT COUNT(*) FROM tblCovidInfo WHERE covStatus = 2) recovered, 
            (SELECT COUNT(*) FROM tblCovidInfo WHERE covStatus = 3) death", null);

        if($all_post["req_result"]) {
            return $all_post["req_val"];
        } else {
            return false;
        }
    }
?>