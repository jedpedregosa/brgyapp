<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../../logout");
        exit();
    }

    if(isset($_GET["r_id"])) {
        $res_id = $_GET["r_id"];

        updateStatement("DELETE FROM tblResident WHERE resUname = ?", [$res_id]);
        updateStatement("DELETE FROM tblResident_auth WHERE resUname = ?", [$res_id]);
    }

    header("Location: ../../e-services/barangay-profile");
    exit();

?>