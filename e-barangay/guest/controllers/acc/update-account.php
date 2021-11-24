<?php  
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/GuestMaster.php");
    
    if(!$is_resdnt_lgn) {
        header("Location: ../../logout");
        exit();    
    }

    $post_result = isset($_POST["Fname"])
        && isset($_POST["Mname"])
        && isset($_POST["Lname"])
        && isset($_POST["Suffix"])
        && isset($_POST["CivStat"])
        && isset($_POST["Ctznshp"])
        && isset($_POST["Bdate"])
        && isset($_POST["Sex"])
        && isset($_POST["HouseNum"])
        && isset($_POST["StName"])
        && isset($_POST["Contact"])
        && isset($_POST["Email"])
        && isset($_POST["FbName"])
        && isset($_POST["Voter"]);

    if(!$post_result) {
        goPrev();
    }

    $acc_details = [
        $_POST["Fname"], 
        $_POST["Mname"], 
        $_POST["Lname"], 
        $_POST["Suffix"], 
        $_POST["CivStat"], 
        $_POST["Ctznshp"],
        $_POST["Bdate"],
        $_POST["Sex"],
        $_POST["HouseNum"],
        $_POST["StName"],
        $_POST["Contact"],
        $_POST["Email"],
        $_POST["FbName"],
        $_POST["Voter"],
        $resdnt_uid
    ];

    $auth_details = [
        $_POST["Contact"],
        $_POST["Email"],
        $resdnt_uid
    ];

    $res_up_sql = "UPDATE tblResident SET resFname = ?, resMname = ?, resLname = ?, resSuffix = ?, resCivStat = ?, resCitiznshp = ?, resBdate = ?, resSex = ?, resHouseNum = ?,
        resStName = ?, resContact = ?, resEmail = ?, resFbName = ?, resVoter = ? WHERE resUname = ?";
    $res_auth_up_sql = "UPDATE tblResident_auth SET resContact = ?, resEmail = ? WHERE resUname = ?";

    $up_res = updateStatement($res_up_sql, $acc_details);
    $auth_details = updateStatement($res_auth_up_sql, $auth_details);

    if($up_res && $auth_details) {
        goPrev(300);
    }

    goPrev();

    function goPrev($result = 301) {
        $_SESSION["res_update_set"] = $result;
        header("Location: ../../e-services/view-profile");
        exit();
    }
?>