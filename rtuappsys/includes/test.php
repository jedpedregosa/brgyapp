<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/config.php");

    date_default_timezone_set("Asia/Manila");

        $date = "7/19/21";
        $office = "RTU-O01";
        $tmslot = "TMSLOT-15";

        $currentTime = new DateTime();
        $selectedDate = new DateTime($date);
        $currentTime = strtotime($currentTime->format('Y-m-d'));
        $selectedDate = strtotime($selectedDate->format('Y-m-d'));


        if(!(date('N', strtotime($date)) >= 6)) { // If selected day is not sunday or saturday
            if($selectedDate == $currentTime) {
                $selected_time_start = strtotime(getTimeSlotStart($tmslot));
                if(strtotime("now") < $selected_time_start) {
                    $diff = date_diff(new DateTime(), new DateTime(getTimeSlotStart($tmslot)));
                    $hour_difference = $diff->format('%h');
                    if($hour_difference < (int)hours_scheduling_span) {
                        //setScheduleToInvalid($schedId);
                        echo "test10";
                    }
                } else {
                    //setScheduleToInvalid($schedId);
                    echo "test11";
                    echo strtotime("now");
                }
            } else if($selectedDate < $currentTime) {
                //setScheduleToInvalid($schedId);
                echo "test12";
            }
        } else {
            //setScheduleToInvalid($schedId);
            echo "test13";
        }
?>