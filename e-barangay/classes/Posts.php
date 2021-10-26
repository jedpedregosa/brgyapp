<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Queries.php");

    function getAllPost() {
        $all_post = selectStatement("r", "SELECT * FROM tblAnnouncements ORDER BY sysTime DESC LIMIT 3", null);

        if($all_post["req_result"]) {
            return $all_post["req_val"];
        } else {
            return false;
        }
    }

    function getAllHealthUpd() {
        $all_post = selectStatement("r", "SELECT * FROM tblHealthUpdates ORDER BY sysTime DESC LIMIT 3", null);

        if($all_post["req_result"]) {
            return $all_post["req_val"];
        } else {
            return false;
        }
    }
?>