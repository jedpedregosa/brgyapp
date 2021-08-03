<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Validation.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Schedule.php");

    if(isset($_POST["close_sched_upd"])) {
        if(!(isset($_POST["time_from"]) && isset($_POST["time_to"]) && isset($_POST["close_date"]))) {
            goBack();
        }
    } else {
        goBack();
    }

    $timeFrom = $_POST["time_from"];
    $timeTo = $_POST["time_to"];
    $closeDate = $_POST["close_date"];
    
    if(!validateDate($closeDate)) {
        goBack();
    } else if(!validateTime($timeTo) || !validateTime($timeFrom)) {
        goBack();
    }

    $result = closeAllSelectSched($assigned_office, $closeDate, $timeFrom, $timeTo);
    
    $_SESSION["close_sched_status"] = $result;
    $_SESSION["err_oadmin"] = 200;

    goBack();

    function goBack() {
        header("Location: ../page/dashboard");
        die();
    }
?>