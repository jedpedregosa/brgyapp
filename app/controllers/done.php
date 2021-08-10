<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");

    $app_key;
    $errorCode;
    
    if(isset($_POST["app_done"])) {
        if(isset($_POST["app_key"])) {
            if(isAppKeyValid($_POST["app_key"])) {
                $app_key = $_POST["app_key"];
            } else {
                goBack();
            }
        } else {
            goBack();
        }
    } else {
        goBack(); 
        // Error Message
    }

    $appointment_id = getAppointmentIdByAppointmentKey($app_key);
    $office_id = getAppointmentOffice($appointment_id);
    $app_date = getAppointmentDate($appointment_id);

    $today_r = new DateTime();
    $today = $today_r->format("Y-m-d");

    if($assigned_office != $office_id) {
        goBack();
    } else if(strtotime($today) != strtotime($app_date)) {
        goBack();
    }

    $result1 = deleteAppointmentKeys($appointment_id);
    $result2 = setVisitorOpen($appointment_id);
    $result3 = setAppointmentAsDone($appointment_id);

    if($result1 && $result2 && $result3) {
        $errorCode = 300;
    }

    goBack($errorCode);

    function goBack($errorCode = 301) {
        $_SESSION["err_oadmin"] = $errorCode;
        header("Location: ../page/dashboard");
        die();
    }
?>