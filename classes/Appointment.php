<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Visitor.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Schedule.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/create-pdf.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/api/phpqrcode/qrlib.php");

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

        $app_key = getAppointmentKeyByAppointmentId($app_id);
        $file_to_delete = APP_FILES . $app_key . "/";

        deleteAppFiles($file_to_delete);

        $stmt = $conn->prepare("DELETE FROM tbl_appointment_auth WHERE app_id = ?");
        $result = $stmt->execute([$app_id]);

        return $result;
    }

    function deleteAppFiles($dir) {
        $items = scandir($dir);

        if($items) {
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                $path = $dir.'/'.$item;
                if (is_dir($path)) {
                    xrmdir($path);
                } else {
                    unlink($path);
                }
            }
            rmdir($dir);
        }  
    }

    function doesAppointmentDoneDataExist($app_id) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT COUNT(*) FROM tbl_appointment_done WHERE app_id = ?");
        $stmt->execute([$app_id]);
        
        return $stmt->fetchColumn();
    }

    function isAppointmentDone($app_id) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT COUNT(*) FROM tbl_appointment WHERE app_id = ? AND app_is_done = 1");
        $stmt->execute([$app_id]);
        
        return $stmt->fetchColumn();
    }

    function setAppointmentAsDone($app_id) {
        $conn = connectDb();

        if(!isAppointmentDone($app_id)) {
            $date_r = new DateTime();
            $date = $date_r->format("Y-m-d H:i:s");

            $stmt = $conn->prepare("UPDATE tbl_appointment SET app_is_done = 1, app_done_date = ? WHERE app_id = ?");
            $result1 = $stmt->execute([$date, $app_id]);
    
            if(doesAppointmentDoneDataExist($app_id)) {
                $office_id = getAppointmentOffice($app_id);
                $office_name = getOfficeName($office_id);
    
                $stmt = $conn->prepare("UPDATE tbl_appointment_done SET office_id = ?, office_name = ?, app_done_date = ? WHERE app_id = ?");
                $result2 = $stmt->execute([$office_id, $office_name, $date,  $app_id]);
            } else {
                $result2 = insertAppointmentDone($app_id, false);
            }
            return $result1 && $result2;
        }

        return false;
    }

    function insertAppointmentDone($app_id, $isWalkin) {
        $conn = connectDb();
        
        $date_r = new DateTime();
        $date = $date_r->format("Y-m-d H:i:s");

        $office_name = "WALKED-IN";
        $office_id = "WALKED-IN";
        
        $raw_app = getAppointmentData($app_id);
        $app_date = getAppointmentDate($app_id);
        $sched_data = getScheduleDetailsByAppointmentId($app_id);
        $for_time = getValues($sched_data[3], $sched_data[2]);
        
        if(!$isWalkin) {
            $office_name = $for_time["officeValue"];
            $office_id = $raw_app[0];
        }
    
        $time_span = $for_time["timeValue"];

        $query = "INSERT INTO tbl_appointment_done (app_id, office_id, office_name, app_branch, app_date, tmslot, app_purpose, app_sys_time, app_done_date) 
            VALUES (:id, :offid, :oname, :branch, :adate, :atime, :purp, :systime, :done)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $app_id);
        $stmt->bindParam(":offid", $office_id);
        $stmt->bindParam(":oname", $office_name);
        $stmt->bindParam(":branch", $raw_app[1]);
        $stmt->bindParam(":adate", $app_date);
        $stmt->bindParam(":atime", $time_span);
        $stmt->bindParam(":purp", $raw_app[2]);
        $stmt->bindParam(":systime", $raw_app[3]);
        $stmt->bindParam(":done", $date);

        $result1 = $stmt->execute();

        $visitor_data = getVisitorDataByAppointmentId($app_id);
        $type = $visitor_data[6];
        $vstor_id = $visitor_data[1];
        $v_key;

        if($type == "student") {
            $v_key = getStudentDataById($vstor_id);
        } else if($type == "employee") {
            $v_key = getEmployeeDataById($vstor_id);
        } else {
            $v_key = getGuestDataById($vstor_id);
            $type = getGuestNextDataById($vstor_id);
        }

        $query = "INSERT INTO tbl_appdone_vstr (app_id, vstor_lname, vstor_fname, vstor_idnum, vstor_contact, vstor_email, type, vstor_ip_add)
            VALUES (:appid, :lname, :fname, :idnum, :contact, :email, :cat, :ip_add)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":appid", $app_id);
        $stmt->bindParam(":lname", $visitor_data[2]);
        $stmt->bindParam(":fname", $visitor_data[3]);
        $stmt->bindParam(":idnum", $v_key);
        $stmt->bindParam(":contact", $visitor_data[4]);
        $stmt->bindParam(":email", $visitor_data[5]);
        $stmt->bindParam(":cat", $type);
        $stmt->bindParam(":ip_add", $visitor_data[8]);

        $result2 = $stmt->execute();

        return $result1 && $result2;
    }

    function getAppointmentData($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_id, app_branch, app_purpose, app_sys_time FROM tbl_appointment WHERE app_id = ?");
        $stmt->execute([$app_id]);

        return $stmt->fetch();
    }

    function isAppointmentWalkin($office_id, $app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_app_wlkin WHERE office_id = ? AND app_id = ?");
        $stmt->execute([$office_id, $app_id]);

        return $stmt->fetchColumn();
    }

    function setAppointmentAsWalkin($office_id, $app_id) {
        $conn = connectDb();

        $date_r = new DateTime();
        $date = $date_r->format("Y-m-d H:i:s");

        $result1 = false;
        $result2 = false;

        if(!isAppointmentWalkin($office_id, $app_id)) {
            $result1 = true;
            if(!doesAppointmentDoneDataExist($app_id)) {
                $result1 = insertAppointmentDone($app_id, true);
            }

            $stmt = $conn->prepare("INSERT INTO tbl_app_wlkin (office_id, app_id, wlkin_date)
                VALUES (?, ?, ?)");
            $result2 = $stmt->execute([$office_id, $app_id, $date]);
        }

        return $result1 && $result2;
    }

    function getAppointmentKeyByQr($qr_key) {
        $conn = connectDb();

        $stmt=$conn->prepare("SELECT app_key FROM tbl_appointment_auth WHERE qr_key = ?");
        $stmt->execute([$qr_key]);

        return $stmt->fetchColumn();
    }
    function getDoneAppointments($office){
        $conn = connectDb();

        $done_appointments = [];
        $stmt = $conn->prepare("SELECT app_id, app_date, tmslot, app_purpose, app_sys_time, app_done_date 
            FROM tbl_appointment_done WHERE office_id = ? ORDER BY app_num DESC, app_done_date desc LIMIT 50");
        $stmt->execute([$office]);

        $r_appdone = [];
        while($row = $stmt->fetchAll()) {
            $r_appdone = array_merge($r_appdone, $row);
        }

        foreach((array)$r_appdone as $app) {
            $appointment = [];
            $app_id = $app[0];
            
            $stmt_vstor = $conn->prepare("SELECT vstor_lname, vstor_fname, vstor_idnum, vstor_contact, vstor_email, type 
                FROM tbl_appdone_vstr WHERE app_id = ?");
            $stmt_vstor ->execute([$app_id]);
            $result = $stmt_vstor->fetch();

            $appointment = array_merge($app, $result);
            array_push($done_appointments, $appointment);
        }

        return $done_appointments;
    }

    function getWalkinAppointments($office) {
        $conn = connectDb();

        $walkin_app = [];

        $stmt = $conn->prepare("SELECT app_id, wlkin_date FROM tbl_app_wlkin WHERE office_id = ? ORDER BY wlkin_num DESC, wlkin_date desc LIMIT 50");
        $stmt->execute([$office]);

        $r_walkin = [];
        while($row = $stmt->fetchAll()) {
            $r_walkin = array_merge($r_walkin , $row);
        }

        foreach((array)$r_walkin as $app) {
            $app_id = $app[0];

            $stmt = $conn->prepare("SELECT app_id, app_date, tmslot, app_purpose, app_sys_time
                FROM tbl_appointment_done WHERE app_id = ?");
            $stmt->execute([$app_id]);
            $app_data = $stmt->fetch();

            array_push($app_data, $app[1]);

            $stmt_vstor = $conn->prepare("SELECT vstor_lname, vstor_fname, vstor_idnum, vstor_contact, vstor_email, type 
                FROM tbl_appdone_vstr WHERE app_id = ?");
            $stmt_vstor ->execute([$app_id]);
            $vstor_data = $stmt_vstor->fetch();
    
            $app_row = array_merge($app_data, $vstor_data);
            array_push($walkin_app, $app_row);
        }

        return $walkin_app;
    }

    function doesEmailHasAppData($email) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT vstor_id FROM tbl_visitor WHERE vstor_email = ?");
        $stmt->execute([$email]);
        $vstor_id = $stmt->fetchColumn();

        if(!$vstor_id) {
            return false;
        }

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment WHERE vstor_id = ?");
        $stmt->execute([$vstor_id]);
        
        return $stmt->fetchColumn();
    }

    function isReschedAllowed($app_id) {
        $app_date = getAppointmentDate($app_id);

        $interval;
        $currentDateTime = new DateTime();
        $current = $currentDateTime->format("Y-m-d");

        $appDateTime = new DateTime($app_date);
        $appdate = $appDateTime->format("Y-m-d");

        if(strtotime($current) < strtotime($appdate)) {
            $interval = $currentDateTime->diff($appDateTime);
            $interval = $interval->format('%R%a');

            if((int)days_rescheduling_span <= (int)$interval) {
                return true;
            }
        }

        return $interval;
    }

    function reschedAppointment($app_id, $new_date, $new_time) {
        $conn = connectDb();

        $office = getAppointmentOffice($app_id);
        
        $slctd_date = new DateTime($new_date);
        $submtDate = $slctd_date->format('ymd');
        $dateForSched = $slctd_date->format('Y-m-d');
        $office_id = str_replace("RTU-O", "", $office);
        $time_id = str_replace("TMSLOT-", "", $new_time);
        $sched_id = $submtDate . $office_id . $time_id;

        checkTimeSlotValidity($new_date, $office, $new_time, $sched_id);

        if(isSchedAvailable($sched_id)) {

            deleteAppointmentKeys($app_id);

            if(!doesSchedExist($sched_id)) {
                // !!!: Lacks Time Slot Id && Office Id Availability Checker
                createSched($sched_id, $dateForSched, $new_time, $office); // Lacks Query Catch
            } 
            addToSchedTotalVisitor($sched_id);

            $new_queue_num = checkSchedTotalVisitor($sched_id);

            $new_app_id = $sched_id . $new_queue_num;
            $stmt = $conn->prepare("UPDATE tbl_appointment SET app_id = ?, sched_id = ? WHERE app_id = ?");
            $result = $stmt->execute([$new_app_id, $sched_id, $app_id]);

            $keys_result = createNewAppointmentKeys($new_app_id);
            generateNewAppFiles($new_app_id);

            return $result && $keys_result;
        } else {
            return 101;
        }
    }

    function createNewAppointmentKeys($app_id) {
        $conn = connectDb();

        // Generate random string then translate into hash to set as an unreadable key for the appointment 
        $randomString = generateRandomString();
        $appointmentKey = hash("sha256", $app_id . $randomString);
        $qr_key = $app_id . generateRandomString(6);

        $fkey1 = generateRandomString();
        $fkey2 = generateRandomString();

        $stmt = $conn -> prepare("INSERT INTO tbl_appointment_auth (app_id, app_key, f_key1, f_key2, qr_key) 
            VALUES (:appno, :appkey, :fkey, :fkeyy, :qr)");
        $stmt-> bindParam(':appno', $app_id);
        $stmt-> bindParam(':appkey', $appointmentKey);
        $stmt-> bindParam(':fkey', $fkey1);
        $stmt-> bindParam(':fkeyy', $fkey2);
        $stmt-> bindParam(':qr', $qr_key);
        $submitResult = $stmt->execute();

        return $submitResult;
    }

    function generateNewAppFiles($app_id) {
        $appointmentKey = getAppointmentKeyByAppointmentId($app_id);
        $file_keys = getFileKeysByAppId($app_id);

        $file_dir = APP_FILES . $appointmentKey . "/";
        if(!is_dir($file_dir)) {
            mkdir($file_dir);
        }

        $flname = $file_keys[0] . ".png";
        $qrfilepath = $file_dir . $flname;

        if (!file_exists($qrfilepath)) {
            QRcode::png(HTTP_PROTOCOL . $_SERVER['HTTP_HOST' ]. "/rtuappsys/direct?an_=". $appointmentKey, $qrfilepath); //should be a default link
        }
        $visitor_data = getVisitorDataByAppointmentId($app_id);
        
        if(!file_exists($file_dir . $file_keys[1] .'.pdf')) {
            generateAppointmentFile($app_id);
        }

    }

?>