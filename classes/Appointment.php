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

        $stmt = $conn->prepare("SELECT sched_id FROM tbl_schedule WHERE office_id = ? AND sched_date = ? ");
        $stmt-> execute([$office, $sched_date]);

        $schedules = [];
        while($row = $stmt->fetchAll()) {
            $schedules = array_merge($schedules, $row);
        } // Lacks checker if db fails (to error page)
        
        $total_count = 0;
        foreach((array)$schedules as $sched) {
            $sched_to_count = $sched[0];

            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment WHERE sched_id = ? AND app_is_done = 0");
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
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment WHERE sched_id = ?  AND app_is_done = 0");
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
        $now_date = $date->format("Y-m-d");

        $stmt = $conn->prepare("SELECT sched_id from tbl_schedule where DATE_FORMAT(sched_date, '%m-%Y') = ? AND (office_id = ? AND sched_date >= ?)");
        $stmt-> execute([$sched_date, $office, $now_date]);

        $schedules = [];
        while($row = $stmt->fetchAll()) {
            $schedules = array_merge($schedules, $row);
        }

        $total_count = 0;
        foreach((array)$schedules as $sched) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment WHERE sched_id = ?  AND app_is_done = 0");
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

    function getFileKeysByAppId($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT f_key1, f_key2, qr_key FROM tbl_appointment_auth WHERE app_id = ?");
        $stmt-> execute([$app_id]);
        $result = $stmt->fetch();

        return $result;
    }

    function isAppKeyValid($app_key) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment_auth WHERE app_key = ?");
        $stmt-> execute([$app_key]);
        $result = $stmt->fetchColumn();

        return $result;
    }

    function arrangeAppointmentData($app_id) {
        $visitor_data = getVisitorDataByAppointmentId($app_id);
        $app_data = getAppointmentDetails($app_id);
        $sched_data = getScheduleDetailsByAppointmentId($app_id);

        $type = $visitor_data[6];
        $vstor_id = $visitor_data[1];
        $v_key;

        $result = [];

        $date_r = new DateTime($sched_data[4]);
        $date = $date_r->format("D, F d, Y");

        $office_time = getValues($sched_data[3], $sched_data[2]);
        $office_name = $office_time["officeValue"];
        $time_span = $office_time["timeValue"];

        if($type == "student") {
            $v_key = getStudentDataById($vstor_id);
        } else if($type == "employee") {
            $v_key = getEmployeeDataById($vstor_id);
        } else {
            $gov_id = getGuestDataById($vstor_id);
            $company = getGuestNextDataById($vstor_id);

            $result = [
                $type,
                $sched_data[3],
                $visitor_data[5],                           //Email, ID Nums
                $visitor_data[3] . " " . $visitor_data[2],    // Full Name
                $visitor_data[4],                           // Contact
                $company,                                   // Company, Email
                $app_data[5],                               // Campus
                $date,                                      // Date
                $office_name,
                $time_span,
                $app_data[6],
                $gov_id
            ];

            return $result;
            die();
        }

        $result = [
            $type,
            $sched_data[3],
            $v_key,                                     //Email, ID Nums
            $visitor_data[3] . " " . $visitor_data[2],    // Full Name
            $visitor_data[4],                           // Contact
            $visitor_data[5],                           // Company, Email
            $app_data[5],                               // Campus
            $date,                                      // Date
            $office_name,
            $time_span,
            $app_data[6],
        ];
        return $result;
    }

    function getAppointmentOffice($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_id FROM tbl_appointment WHERE app_id = ?");
        $stmt-> execute([$app_id]);

        return $stmt->fetchColumn();
    }

    function getAppointmentDate($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT sched_id FROM tbl_appointment WHERE app_id = ?");
        $stmt-> execute([$app_id]);
        $sched_id = $stmt->fetchColumn();

        $stmt = $conn->prepare("SELECT sched_date FROM tbl_schedule WHERE sched_id = ?");
        $stmt-> execute([$sched_id]);

        return $stmt->fetchColumn();
    }

    function deleteAppointmentKeys($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("DELETE FROM tbl_appointment_auth WHERE app_id = ?");
        $result = $stmt->execute([$app_id]);

        return $result;
    }

    function setAppointmentAsDone($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("UPDATE tbl_appointment SET app_is_done = 1 WHERE app_id = ?");
        $result = $stmt->execute([$app_id]);

        return $result;
    }
?>