<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        echo json_encode(array("req_pro_status"=>102));
        exit();
    }

    if(!IS_AJAX) {
        header("Location: ../../home");
    }

    if(isset($_POST["s_val"])) {
        $search = $_POST["s_val"];
        $search = '%' . $search . '%';

        $search_sql = "SELECT resUname, resLname, resFname, sysTime FROM tblResident WHERE 
            resFname LIKE ? OR
            resUname LIKE ? OR
            resMname LIKE ? OR
            resLname LIKE ? OR
            CONCAT(resFname, ' ', resLname) LIKE ? OR
            resHouseNum LIKE ? LIMIT 10";
        $search_res = selectStatement("r", $search_sql, [$search, $search, $search, $search, $search, $search]);

        if($search_res["req_result"]) {
            if($search_res["req_val"]) {
                $vals = $search_res["req_val"];
                $fix_val = [];

                foreach($vals as $v) {
                    $hash_id = hash('sha256', $v["resUname"] . $v["sysTime"]);
                    $v += ["hash_id"=>$hash_id];
                    array_push($fix_val, $v);
                }
                
                echo json_encode(array("req_pro_status"=>100,"req_pro_val"=>$fix_val));
                exit();
            }
        }
    }

    echo json_encode(array("req_pro_status"=>101));
    exit();
?>