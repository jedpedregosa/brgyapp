<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    
    function closeAllSelectSched($office, $date, $from, $to) {
        $conn = connectDb();

        if(strtotime($from) > strtotime($to)) {
            return 0;
        } else if(isDateWeekEnd($date)) {
            return 0;
        }

        $stmt = $conn->prepare("SELECT tmslot_id FROM tbl_timeslot WHERE time_start >= CAST(? AS time) AND time_end <= CAST(? AS time)");
        $stmt->execute([$from, $to]);
        
        $closed_slots = [];
        while($row = $stmt->fetchAll()) {
            $closed_slots = array_merge($closed_slots, $row);
        }

        if(!sizeof($closed_slots)) {
            return 0; 
        }
        
        $affected = sizeof($closed_slots);
        $date_to_close_raw = new DateTime($date);
        $date_to_close = $date_to_close_raw->format("ymd");

        $office_id_key = str_replace("RTU-O", "", $office);

        $affected_slots = [];
        $raw_sched_id = $date_to_close . $office_id_key;

        foreach((array)$closed_slots as $slot) {
            $time_id_key = str_replace("TMSLOT-", "", $slot[0]);
            $sched_id =  $raw_sched_id . $time_id_key;

            if(doesSchedExist($sched_id)) {
                if(!isSchedClosed($sched_id)) {
                    array_push($affected_slots, $slot[0]);
                    setSchedAsClosed($sched_id);
                } else {
                    $affected--;
                }
            } else {
                array_push($affected_slots, $slot[0]);
                createSched($sched_id, $date, $slot[0], $office);
                setSchedAsClosed($sched_id);
            }
        }

        return $affected;
    }

    function isSchedClosed($sched_id) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT sched_isClosed FROM tbl_schedule WHERE sched_id = ?");
        $stmt->execute([$sched_id]);

        $result = $stmt->fetchColumn();
        return $result;
    }

    function setSchedAsClosed($sched_id) {
        $conn = connectDb();

        setScheduleToInvalid($sched_id);

        $stmt = $conn->prepare("UPDATE tbl_schedule SET sched_isClosed = 1 WHERE sched_id = ?");
        $stmt->execute([$sched_id]);
    }

    function getClosedSchedules($office_id) {
        $conn = connectDb();

        $date_to_check = new DateTime();
        $dateTime = $date_to_check->format("Y-m-d");

        $stmt = $conn -> prepare("SELECT sched_date, tmslot_id FROM tbl_schedule WHERE (sched_isClosed = 1 AND office_id = ?) AND sched_date >= date(?)");
        $stmt->execute([$office_id, $dateTime]);

        $closed_slots = [];
        while($row = $stmt->fetchAll()) {
            $closed_slots = array_merge($closed_slots, $row);
        }

        return $closed_slots;
    }

    function isDateWeekEnd($date) {
        $date_to_check = new DateTime($date);
        $dateTime = $date_to_check->format("Y-m-d");

        if(date('N', strtotime($dateTime)) >= 6) {
            return true;
        } else {
            return false;
        }
    }
?>