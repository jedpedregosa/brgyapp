<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../../logout");
        exit();
    }

    $info_id = time();
    $current_time = date("Y-m-d H:i:s");

    $post_req = isset($_POST["firstname"])
        && isset($_POST["middlename"])
        && isset($_POST["lastname"])
        && isset($_POST["suffix"])
        && isset($_POST["covtype"])
        && isset($_POST["contact"])
        && isset($_POST["email"])
        && isset($_POST["citizenship"])
        && isset($_POST["age"])
        && isset($_POST["sex"])
        && isset($_POST["hnum"])
        && isset($_POST["stname"])
        && isset($_POST["admitted"])
        && isset($_POST["discharge"])
        && isset($_POST["start"])
        && isset($_POST["end"])
        && isset($_POST["s_start"])
        && isset($_POST["hospital"])
        && isset($_POST["s_last_contact"])
        && isset($_POST["last_place"])
        && isset($_POST["last_contact"])
        && isset($_POST["s_end"]);
    
    if(!$post_req) {
        goPrev();
    }

    $symptoms = null;
    if(isset($_POST["symptoms"])) {
        if(!empty($_POST["symptoms"])) {
            foreach($_POST["symptoms"] as $type) {
                $symptoms .= $type . ", ";
            }
        }
    }

    if(!empty($_POST['last_contact'])) 
        $lastCon = $_POST['last_contact'];
    else if(!empty($_POST["s_last_contact"]))
        $lastCon = $_POST["s_last_contact"];
    else    
        $lastCon = null;

    if(!empty($_POST["start"]))
        $start = $_POST["start"]; 
    else if(!empty($_POST["s_start"]))
        $start = $_POST["s_start"];
    else    
        $start = null;

    if(!empty($_POST["end"])) 
        $end = $_POST["end"]; 
    else if(!empty($_POST["s_end"]))
        $end = $_POST["s_end"];
    else 
        $end = null;

    $post_data = [
        $info_id,
        $_POST["firstname"],
        $_POST["middlename"],
        $_POST["lastname"],
        $_POST["suffix"],
        $_POST["covtype"],
        $_POST["contact"],
        $_POST["email"],
        $_POST["citizenship"],
        $_POST["age"],
        $_POST["sex"],
        $_POST["hnum"],
        $_POST["stname"],
        (!empty($_POST["admitted"])) ? $_POST["admitted"] : null,
        (!empty($_POST["discharge"])) ? $_POST["discharge"] : null,
        $start,
        $end,
        $symptoms,
        $_POST["hospital"],
        $_POST["last_place"],
        $lastCon,
        $current_time
    ];

    $info_sql = "INSERT INTO tblCovidInfo (infoId, fName, mName, lName, suffix, covType, contact, email, ctznshp, age, sex, hNum, stName, 
        dateAd, dateDis, dateStart, dateEnd, symptoms, hospital, lastPlace, lastContact, sysTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $insertInfo = insertStatement($info_sql, $post_data);

    if($insertInfo) {
        goPrev(200);
    }

    goPrev();

    function goPrev($result = 201) {
        if($result == 200) {
            header("Location: ../../e-services/covid-info");
        } else {
            $_SESSION["cov_req_status"] = 1;
            header("Location: ../../e-services/add-covid-info");
        }
        exit();
    }

?>