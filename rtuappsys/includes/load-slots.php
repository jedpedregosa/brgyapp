<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/config.php");

    // Check if request is not from ajax
    if(!IS_AJAX) {
        header("Location: ../main/rtuappsys.php");
		die();
    }

    if(isset($_POST["date"]) && isset($_POST["office"])) {
        $slctDate = $_POST["date"];
        $slctOffice = $_POST["office"];
    } else {
        // *********** Needs error message
        header("Location: ../main/rtuappsys.php");
        die();
    }

    //$slctDate = "07/15/2021";
    //$slctOffice = "RTU-O01";

    $availableSlots = [];

    $slctd_date = new DateTime($slctDate);
    $checkDate = $slctd_date->format('ymd');
    $officeId = str_replace("RTU-O", "", $slctOffice);

    for($i = 1; $i <= (int)number_of_timeslots; $i++) {
        $timeId = $i <= 9 ? "0" . $i : $i;
        $schedId = $checkDate . $officeId . $timeId;
       
        $slot = "TMSLOT-" . $timeId;
        checkTimeSlotValidity($slctDate, $slctOffice, $slot, $schedId);
        array_push($availableSlots, [$slot, isSchedAvailable($schedId)]);

    }
    echo json_encode($availableSlots);

?>