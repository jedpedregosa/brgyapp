<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    function totalAppointmentToday($office) {
        
        $conn = connectDb();

        $date = new DateTime();
        $sched_date = $date->format("Y-m-d");

        $weekday = date('N', strtotime($sched_date));
        if($weekday>= 6) {
            return ($weekday == 6 ? "Today's Saturday." : "Today's Sunday.");
        }

        $stmt = $conn->prepare("SELECT sched_id FROM tbl_schedule WHERE office_id = ? AND sched_date = ?");
        $stmt-> execute([$office, $sched_date]);

        $schedules = [];
        while($row = $stmt->fetchAll()) {
            $schedules = array_merge($schedules, $row);
        } // Lacks checker if db fails (to error page)
        
        $total_count = 0;
        foreach((array)$schedules as $sched) {
            $sched_to_count = $sched[0];

            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment WHERE sched_id = ?");
            $stmt-> execute([$sched_to_count]);

            $result = $stmt->fetchColumn();
            $total_count = $total_count + (int)$result;
        }

        return $total_count;
    }
    function totalAppointmentOfWeek($office) {
        $conn = connectDb();

        $date = new DateTime();
        $sched_date = $date->format("Y-m-d");

        $stmt = $conn->prepare("SELECT sched_id from tbl_schedule where (sched_date BETWEEN ? AND DATE_ADD(?, INTERVAL 7 DAY)) AND office_id = ?");
        $stmt-> execute([$sched_date, $sched_date, $office]);

        $schedules = [];
        while($row = $stmt->fetchAll()) {
            $schedules = array_merge($schedules, $row);
        }

        $total_count = 0;
        foreach((array)$schedules as $sched) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment WHERE sched_id = ?");
            $stmt-> execute([$sched[0]]);

            $result = $stmt->fetchColumn();
            $total_count += (int)$result;
        }

        return $total_count;
    }

    function totalAppointmentOfMonth($office) {
        $conn = connectDb();

        $date = new DateTime();
        $sched_date = $date->format("m-Y");

        $stmt = $conn->prepare("SELECT sched_id from tbl_schedule where DATE_FORMAT(sched_date, '%m-%Y') = ? AND office_id = ?");
        $stmt-> execute([$sched_date, $office]);

        $schedules = [];
        while($row = $stmt->fetchAll()) {
            $schedules = array_merge($schedules, $row);
        }

        $total_count = 0;
        foreach((array)$schedules as $sched) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment WHERE sched_id = ?");
            $stmt-> execute([$sched[0]]);

            $result = $stmt->fetchColumn();
            $total_count += (int)$result;
        }

        return $total_count;
    }
?>