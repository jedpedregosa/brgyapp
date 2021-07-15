<?php 
    /////////////// SOURCE CODE TESTING PAGE 
    /// DELETE test2.php ON PRODUCTION

    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");


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
    $endDate = date('Y-m-d', strtotime($startDate . ' + 30 days'));

    $availableDates = [];

    $i = $startDate;
    while($i <= $endDate) {
        if(!(date('N', strtotime($i)) >= 6)) {
            if(checkDaySched($i, $office)) {
                array_push($availableDates, $i);
            }
        }
        $i = date('Y-m-d', strtotime($i. ' + 1 days'));
    }
    echo json_encode($availableDates);

?>