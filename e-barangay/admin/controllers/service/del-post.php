<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../../logout");
        exit();
    }

    if(isset($_GET["p_id"]) && isset($_GET["type"])) {
        $post_id = $_GET["p_id"];

        if($_GET["type"] == 1) {
            updateStatement("DELETE FROM tblAnnouncements WHERE anncmntId = ?", [$post_id]);
        } else if($_GET["type"] == 2) {
            updateStatement("DELETE FROM tblHealthUpdates WHERE updateId = ?", [$post_id]);
        }
    }

    header("Location: ../../home");
    exit();

?>