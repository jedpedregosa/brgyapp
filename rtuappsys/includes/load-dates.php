<?php 
    // LACKS SESSION CHECKER!!!!!!!!!!!

    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/config.php");

    // Check if request is not from ajax
    if(!IS_AJAX) {
        header("Location: ../main/rtuappsys.php");
		die();
    }

    if(isset($_POST['officeCode'])) {
        $office = $_POST['officeCode'];
    } else {
        // *********** Needs error message
        header("Location: ../main/rtuappsys.php");
        die();
    }

    date_default_timezone_set("Asia/Manila");
    $slctd_date = new DateTime();
    $startDate = $slctd_date->format('Y-m-d');

    $availableDates = [];

    $date = $startDate;
    $i = 1;
    while($i <= (int)days_scheduling_span) {
        if(!(date('N', strtotime($date)) >= 6)) {
            if(checkDaySched($date, $office)) {
                array_push($availableDates, $date);
                $i += 1;
            }
        }
        $date = date('Y-m-d', strtotime($date. ' + 1 days'));
    }
    echo json_encode($availableDates);

?>