<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/SystemLog.php");

    $max_visitor;
    $day_span;
    $hours_span;
    $day_rsched;

    if(isset($_POST["upd_sysvar"])) {
        $post1 = isset($_POST["max_visitor"]) && isset($_POST["days_resched"]);
        $post2 = isset($_POST["days_span"]) && isset($_POST["hours_span"]);
        if(!($post1 && $post2)) {
            goBack();
        }

        $max_visitor = $_POST["max_visitor"];
        $day_span = $_POST["days_span"];
        $hours_span = $_POST["hours_span"];
        $day_rsched = $_POST["days_resched"];

    } else {
        goBack();
    }

    if(!boolval(sys_in_maintenance)) {
        goBack(401);
    }
    $is_valid = is_numeric($day_rsched) && is_numeric($day_span);
    $is_valid2 = is_numeric($max_visitor) && is_numeric($hours_span);
    if(!($is_valid2 && $is_valid)) {
        goBack();
    }

    if($max_visitor < 5 || $max_visitor > 9) {
        goBack();
    } else if($hours_span < 1 || $hours_span > 24) {
        goBack();
    } else if($day_rsched < 1 || $day_rsched > 5) {
        goBack();

    } else if($day_span < 15 || $day_span > 90) {
        goBack();
    }

    $result = updateSystemVariables($max_visitor, $day_span, $hours_span, $day_rsched);

    if($result) {
        goBack(400);
        
        createLog($config_admin_id, "A", USER_IP);
    } 

    goBack();

    function goBack($errorCode = 402) {
        $_SESSION["upd_sys_config"] = $errorCode;
        header("Location: ../page/sys-settings");
        die();
    }
?>