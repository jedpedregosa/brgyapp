<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Visitor.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Schedule.php");

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

    function getNearAvailableDate() {
        $currentDateTime = new DateTime();
        $dateTime = $currentDateTime->format("Y-m-d");

        while(true) {
            if(!(date('N', strtotime($dateTime)) >= 6)) {
                return $dateTime;
            } else {
                $dateTime = date('Y-m-d', strtotime($dateTime. ' + 1 days'));
            }
        }
            
    } 

    function getMaxAvailableDate() {
        $currentDateTime = new DateTime(getNearAvailableDate());
        $dateTime = $currentDateTime->format("Y-m-d");

        return date('Y-m-d', strtotime($dateTime. ' + 90 days'));
    } 

    function getAllAppointments($office, $type, $time_by) {
        $conn = connectDb();

        $date = new DateTime();
        $sched_date = $date->format("Y-m-d");

        $appointments = [];

        if($time_by == 1) {
            $stmt = $conn->prepare("SELECT sched_id FROM tbl_schedule WHERE office_id = ? AND sched_date = ?");
            $stmt-> execute([$office, $sched_date]);

            $schedules = [];
            while($row = $stmt->fetchAll()) {
                $schedules = array_merge($schedules, $row);
            } // Lacks checker if db fails (to error page)
            
            foreach((array)$schedules as $sched) {
                $stmt = $conn->prepare("SELECT app_id, vstor_id, sched_id, app_purpose FROM tbl_appointment WHERE sched_id = ?  AND app_is_done = 0");
                $stmt-> execute([$sched[0]]);

                while($row = $stmt->fetchAll()) {
                    $appointments = array_merge($appointments, $row);
                }
            }
        } else if($time_by == 7) {
            $stmt = $conn->prepare("SELECT sched_id from tbl_schedule where (sched_date BETWEEN ? AND DATE_ADD(?, INTERVAL 7 DAY)) AND office_id = ?");
            $stmt-> execute([$sched_date, $sched_date, $office]);

            $schedules = [];
            while($row = $stmt->fetchAll()) {
                $schedules = array_merge($schedules, $row);
            }

            $total_count = 0;
            foreach((array)$schedules as $sched) {
                $stmt = $conn->prepare("SELECT app_id, vstor_id, sched_id, app_purpose FROM tbl_appointment WHERE sched_id = ? AND app_is_done = 0");
                $stmt-> execute([$sched[0]]);

                while($row = $stmt->fetchAll()) {
                    $appointments = array_merge($appointments, $row);
                }
            }
        } else {
            $stmt = $conn->prepare("SELECT app_id, vstor_id, sched_id, app_purpose FROM tbl_appointment WHERE app_is_done = 0 AND office_id = ?");
            $stmt->execute([$office]); 

            while($row = $stmt->fetchAll()) {
                $appointments = array_merge($appointments, $row);
            }
        }

        $appointment_result = [];
        foreach((array)$appointments as $app) {
            $appointee_data = getVisitorDataByAppointmentId($app[0]);
            $schedule_details = getScheduleDetailsBySchedId($app[2]);

            $isGuest = false;
            $isStudent = false;
            $isEmp = false;

            $identification_no;
            if($appointee_data[6] == "student") {
                $isStudent = true;
                $identification_no = getStudentDataById($appointee_data[1]);
            } else if($appointee_data[6] == "employee") {
                $isEmp = true;
                $identification_no = getEmployeeDataById($appointee_data[1]);
            } else {
                $isGuest = true;
                $identification_no = getGuestDataById($appointee_data[1]);
            }

            if($type == "student") {
                if(!$isStudent) {
                    continue;
                }
            } else if($type == "employee") {
                if(!$isEmp) {
                    continue;
                }
            } else if($type == "guest") {
                if(!$isGuest) {
                    continue;
                }
            }

            $time = getTimeSlotStart($schedule_details[0]) . " - " . getTimeSlotEnd($schedule_details[0]);
            array_push($appointment_result, 
                [
                    $app[0], 
                    $identification_no, 
                    $appointee_data[2], 
                    $appointee_data[3], 
                    $appointee_data[4], 
                    $appointee_data[5],
                    $schedule_details[1],
                    $time,
                    $app[3],
                    $appointee_data[6],
                    !isSchedClosed($app[2])
                ]
            );
        }
        return $appointment_result;
    }
?>