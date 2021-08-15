<?php 
    $app_id = "2021-08-13";
    isReschedAllowed("2021-07-13");

    function isReschedAllowed($app_id) {
        $app_date = $app_id;

        $currentDateTime = new DateTime();
        $current = $currentDateTime->format("Y-m-d");

        $appDateTime = new DateTime($app_date);
        $appdate = $appDateTime->format("Y-m-d");

        if(strtotime($current) > strtotime($appdate)) {
            $interval = $currentDateTime->diff($appDateTime);
            echo $interval->format('%a');
        }

    }
?>