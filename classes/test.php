<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    $conn = connectDb();

    $date = new DateTime();
    $sched_date = $date->format("Y-m-d");
    $office = 'RTU-O01';

    $stmt = $conn->prepare("SELECT sched_id from tbl_schedule where (sched_date BETWEEN ? AND DATE_ADD(?, INTERVAL 7 DAY)) AND office_id = ?");
    $stmt-> execute([$sched_date, $sched_date, $office]);

    $schedules = [];
    while($row = $stmt->fetchAll()) {
        $schedules = array_merge($schedules, $row);
    }

    $total_count = 0;
    foreach((array)$schedules as $sched) {
        $sched_to_count = $sched[0];

            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment WHERE sched_id = ?");
            $stmt-> execute([$sched_to_count]);

            $result = $stmt->fetchColumn();
            $total_count = $total_count + (int)$result;
    }
    echo $total_count;
?>