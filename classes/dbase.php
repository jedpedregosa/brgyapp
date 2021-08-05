<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/module.php");

    function connectDb() {
        $conn;
        try {
            $conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name, db_user, db_pw);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage(); 
            // Catch if db fails
        }
        return $conn;
    }

    function createVisitorId() {
        $conn = connectDb();

        $stmt = $conn->query("SELECT MAX(vstor_num) FROM tbl_visitor");
        $user = $stmt->fetchColumn(); 

        if($user) {
            return $user + 1;
        } else {
            return 1;
        }
        
    }

    function getValues($officeCode, $timeCode) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_name FROM tbl_office WHERE office_id = ?");
        $stmt-> execute([$officeCode]);
        $officeValue = $stmt->fetchColumn();

        $stmt = $conn->prepare("SELECT CONCAT(tmslot_start, ' - ', tmslot_end) FROM tbl_timeslot WHERE tmslot_id = ?");
        $stmt-> execute([$timeCode]);
        $timeValue = $stmt->fetchColumn();

        // Catch if db fails 
        return array("officeValue"=>$officeValue, "timeValue" => $timeValue);
    }
    
    function doesUserHasApp($userID, $userType) {
        $conn = connectDb();
        $result = null;
        $stmt = null;

        if(!(doesUserExists($userID, $userType))) { // Check if user does not exists on the database
            return false;
        }

        if($userType == "student") {
            $stmt = $conn->prepare("SELECT vstor_hasApp FROM tbl_visitor WHERE vstor_id = (SELECT vstor_id FROM tbl_student_data WHERE student_num = ?)");
            $stmt-> execute([$userID]);    
        } else if($userType == "employee") {
            $stmt = $conn->prepare("SELECT vstor_hasApp FROM tbl_visitor WHERE vstor_id = (SELECT vstor_id FROM tbl_employee_data WHERE employee_num = ?)");
            $stmt-> execute([$userID]);
        } else {
            $stmt = $conn->prepare("SELECT vstor_hasApp FROM tbl_visitor WHERE vstor_email = ?");
            $stmt-> execute([$userID]);
        }
        //// Other User Types on Else-ifs
        $result = $stmt->fetchColumn(); // Lacks checker if db fails (to error page)

        return $result;
    }

    function doesUserExists($userID, $userType) {
        $conn = connectDb();
        $stmt = null;
        $result = null;
        
        if($userType == "student") {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_student_data WHERE student_num = ?");
            $stmt-> execute([$userID]);
        } else if($userType == "employee") {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_employee_data WHERE employee_num = ?");
            $stmt-> execute([$userID]);
        } else {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_guest_data WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = ?)");
            $stmt-> execute([$userID]);
        }
        //// Other User Types on Else-ifs
        $result = $stmt->fetchColumn(); // Lacks checker if db fails (to error page)

        return $result;
    }

    function getUserData($userID, $userType) {
        $conn = connectDb();
        $stmt = null;
        $result = [];
        
        if($userType == "student") {
            $stmt = $conn->prepare("SELECT vstor_fname, vstor_contact, vstor_email FROM tbl_visitor WHERE vstor_id =
            (SELECT vstor_id FROM tbl_student_data WHERE student_num = ?)");
            $stmt-> execute([$userID]);
        } else if($userType == "employee") {
            $stmt = $conn->prepare("SELECT vstor_fname, vstor_contact, vstor_email FROM tbl_visitor WHERE vstor_id =
            (SELECT vstor_id FROM tbl_employee_data WHERE employee_num = ?)");
            $stmt-> execute([$userID]);
        } else {
            $stmt = $conn->prepare("SELECT vstor_fname, vstor_contact, vstor_email FROM tbl_visitor WHERE vstor_email = ?");
            $stmt-> execute([$userID]);

            $result = $stmt->fetch();

            $stmt = $conn->prepare("SELECT company, government_id FROM tbl_guest_data 
            WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = ?)");
            $stmt-> execute([$userID]);
        }
        //// Other User Types on Else-ifs
        $result = array_merge($result, $stmt->fetch()); // Lacks checker if db fails (to error page)

        return $result;
    }

    function getUserDataByEmailLastN($v_email, $v_lname, $userType) {
        $conn = connectDb();
        $stmt = null;
        $result = [];

        $stmt = $conn->prepare("SELECT vstor_fname, vstor_contact FROM tbl_visitor WHERE vstor_email = ? AND vstor_lname = ?");
        $stmt-> execute([$v_email, $v_lname]);

        $result = $stmt->fetch();

        if($userType == "student") {
            $stmt = $conn->prepare("SELECT student_num FROM tbl_student_data 
            WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = ? AND vstor_lname = ?)");
            $stmt-> execute([$v_email, $v_lname]);
        } else if($userType == "employee") {
            $stmt = $conn->prepare("SELECT employee_num FROM tbl_employee_data 
            WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = ? AND vstor_lname = ?)");
            $stmt-> execute([$v_email, $v_lname]);
        } else {
            $stmt = $conn->prepare("SELECT company, government_id FROM tbl_guest_data 
            WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = ? AND vstor_lname = ?)");
            $stmt-> execute([$v_email, $v_lname]);
        }
        //// Other User Types on Else-ifs
        $result = array_merge($result, $stmt->fetch()); // Lacks checker if db fails (to error page)

        return $result;
    }
 
    function insertUserData($userData, $userType) {
        $conn = connectDb();
        $visitorID = "VSTOR-" . createVisitorId();

        if(doesEmailExists($userData[3])) {
            if(!doesEmailHasApp($userData[3])) {               
                delUserByEmail($userData[3], getUserTypeByEmail($userData[3])); 
            } else {
                return false;
            }
        }
        
        $stmt = $conn -> prepare("INSERT INTO tbl_visitor (vstor_id, vstor_lname, vstor_fname, vstor_contact, vstor_email, vstor_type)
        VALUES (:id, :lname, :fname, :phone, :email, :utype)");

        $stmt-> bindParam(':id', $visitorID);
        $stmt-> bindParam(':lname', $userData[1]);
        $stmt-> bindParam(':fname', $userData[2]);
        $stmt-> bindParam(':email', $userData[3]);
        $stmt-> bindParam(':phone', $userData[4]);
        $stmt-> bindParam(':utype', $userType);

        $firstReq = $stmt->execute();
        $secondReq = null;

        if($userType == "student") {
            
            $stmt = $conn -> prepare("INSERT INTO tbl_student_data (student_num, vstor_id)
            VALUES (:studentId, :vstorId)");
            $stmt-> bindParam(':studentId', $userData[0]);
            $stmt-> bindParam(':vstorId', $visitorID);  
        } else if($userType == "employee"){
            $stmt = $conn -> prepare("INSERT INTO tbl_employee_data (employee_num, vstor_id)
            VALUES (:employeeId, :vstorId)");
            $stmt-> bindParam(':employeeId', $userData[0]);
            $stmt-> bindParam(':vstorId', $visitorID);  
        } else {
            $stmt = $conn -> prepare("INSERT INTO tbl_guest_data (vstor_id, company, government_id)
            VALUES (:vstorId, :company, :govId)");
            $stmt-> bindParam(':vstorId', $visitorID);
            $stmt-> bindParam(':company', $userData[5]);
            $stmt-> bindParam(':govId', $userData[6]);
        }

        $secondReq = $stmt->execute(); // Lacks checker if db fails (to error page)

        return $firstReq && $secondReq;
    }

    function updateUserData($userData, $userType) {
        $conn = connectDb();

        $oldEmailOwnerType = getUserTypeByEmail($userData[3]);
        
        $isGuestEligible = ($userData[0] != $userData[3]) && ($userType == "guest");
        $isEmpStudElig = ($userData[3] != getUserData($userData[0], $userType)[2]) && ($userType != "guest");
        if($isGuestEligible || $isEmpStudElig) {
            if(doesEmailExists($userData[3])) {
                // If the old email owner is in the database, delete visitor + data then update the user type.
                delUserByEmail($userData[3], $oldEmailOwnerType);
            } else if (!doesEmailExists($userData[3])) {
                // DO NOTHING
            } else{
                // Internal Error Page
                return false;
            }
        } 
            
            
        if($userType == "student") {
            // Update current user information
            $stmt = $conn->prepare("UPDATE tbl_visitor SET vstor_lname = :lname, vstor_fname = :fname, vstor_contact = :phone, vstor_email = :email
            WHERE vstor_id = (SELECT vstor_id FROM tbl_student_data WHERE student_num = :studno)");

            $stmt-> bindParam(':studno', $userData[0]);
            $stmt-> bindParam(':lname', $userData[1]);
            $stmt-> bindParam(':fname', $userData[2]);
            $stmt-> bindParam(':email', $userData[3]);
            $stmt-> bindParam(':phone', $userData[4]);

            if(!$stmt->execute()) {
                // Dbase Error Page
                return false;
            }
        } else if($userType == "employee") {
            $stmt = $conn->prepare("UPDATE tbl_visitor SET vstor_lname = :lname, vstor_fname = :fname, vstor_contact = :phone, vstor_email = :email
            WHERE vstor_id = (SELECT vstor_id FROM tbl_employee_data WHERE employee_num = :empno)");

            $stmt-> bindParam(':empno', $userData[0]);
            $stmt-> bindParam(':lname', $userData[1]);
            $stmt-> bindParam(':fname', $userData[2]);
            $stmt-> bindParam(':email', $userData[3]);
            $stmt-> bindParam(':phone', $userData[4]);

            if(!$stmt->execute()) {
                // Dbase Error Page
                return false;
            }
        } else if($userType == "guest") {
            $stmt = $conn->prepare("UPDATE tbl_visitor SET vstor_lname = :lname, vstor_fname = :fname, vstor_contact = :phone, vstor_email = :email
            WHERE vstor_email = :userEmail");

            $stmt-> bindParam(':userEmail', $userData[1]);
            $stmt-> bindParam(':lname', $userData[2]);
            $stmt-> bindParam(':fname', $userData[3]);
            $stmt-> bindParam(':email', $userData[4]);
            $stmt-> bindParam(':phone', $userData[5]);

            if(!$stmt->execute()) {
                // Dbase Error Page
                return false;
            }

            $stmt = $conn->prepare("UPDATE tbl_guest_data SET company = :company, government_id = :govId
            WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = :email)");

            $newEmail =  $userData[3] != $userData[0] ? $userData[3] : $userData[0];
            $stmt-> bindParam(':company', $userData[5]);
            $stmt-> bindParam(':govId', $userData[6]);
            $stmt-> bindParam(':email', $newEmail);

            if(!$stmt->execute()) {
                // Dbase Error Page
                return false;
            }
        }            
            
        return true; 
    }

    function getUserTypeByEmail($userEmail) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT vstor_type FROM tbl_visitor WHERE vstor_email = ?");
        $stmt-> execute([$userEmail]);

        $result = $stmt->fetchColumn();

        return $result;
    }

    function getUserEmailById($userId) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT vstor_email FROM tbl_visitor WHERE vstor_email = ?");
        $stmt-> execute([$userId]);

        $result = $stmt->fetchColumn(); // Lacks checker if db fails (to error page)

        return $result;
    }

    function delUserByEmail($userEmail, $userType) {
        $conn = connectDb();

        if($userType == "guest") {
            $stmt = $conn->prepare("DELETE FROM tbl_guest_data WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = :email)");
                $stmt-> bindParam(':email', $userEmail);
                if(!$stmt->execute()) {
                    // Dbase Query Error Page
                    return false;
                }

                
            $stmt = $conn->prepare("DELETE FROM tbl_visitor WHERE vstor_email = :email");
            $stmt-> bindParam(':email', $userEmail);
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            } 
        } else if($userType == "employee") {
            $stmt = $conn->prepare("DELETE FROM tbl_employee_data WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = :email)");
            $stmt-> bindParam(':email', $userEmail);
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            }

            $stmt = $conn->prepare("DELETE FROM tbl_visitor WHERE vstor_email = :email");
            $stmt-> bindParam(':email', $userEmail);
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            }
        } else if($userType == "student") {
            $stmt = $conn->prepare("DELETE FROM tbl_student_data WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = :email)");
            $stmt-> bindParam(':email', $userEmail);
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            }

            $stmt = $conn->prepare("DELETE FROM tbl_visitor WHERE vstor_email = :email");
            $stmt-> bindParam(':email', $userEmail);
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            }
        }
    }

    function doesEmailExists($userId) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_visitor WHERE vstor_email = ?");
        $stmt-> execute([$userId]);

        return $stmt->fetchColumn(); // Lacks Catch
    }
    function doesEmailHasApp($userId) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT vstor_hasApp FROM tbl_visitor WHERE vstor_email = ?");
        $stmt-> execute([$userId]);

        return $stmt->fetchColumn(); // Lacks Catch
    }

    function getVisitorId($userId, $userType) {
        $conn = connectDb();

        if($userType == "student") {
            $stmt = $conn->prepare("SELECT vstor_id FROM tbl_student_data WHERE student_num = ?");
            $stmt-> execute([$userId]);
        } else if($userType == "employee") {
            $stmt = $conn->prepare("SELECT vstor_id FROM tbl_employee_data WHERE employee_num = ?");
            $stmt-> execute([$userId]);
        } else if($userType == "guest"){
            $stmt = $conn->prepare("SELECT vstor_id FROM tbl_visitor WHERE vstor_email = ?");
            $stmt-> execute([$userId]);
        } else {
            /// INTERNAL ERROR PAGE
        }

        return $stmt->fetchColumn(); // Lacks Catch
    }

    function isSchedAvailable($schedId) {
        if(!doesSchedExist($schedId)) {
            return true;
        } 

        $conn = connectDb();

        $stmt = $conn->prepare("SELECT sched_total_visitor FROM tbl_schedule WHERE sched_id = ?");
        $stmt-> execute([$schedId]);

        $total_visitor = (int)$stmt->fetchColumn(); // Lacks Catch
        if(($total_visitor < (int)max_per_sched) && isSchedOpen($schedId)) {
            return true;
        } else {
            setScheduleToInvalid($schedId);
            return false;
        }
    }

    function isSchedOpen($schedId) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT sched_is_available FROM tbl_schedule WHERE sched_id = ?");
        $stmt-> execute([$schedId]);

        return $stmt->fetchColumn();
    }

    function checkTimeSlotValidity($date, $office, $tmslot, $schedId) {
        date_default_timezone_set("Asia/Manila");

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
                        setScheduleToInvalid($schedId);
                    }
                } else {
                    setScheduleToInvalid($schedId);
                }
            } else if($selectedDate < $currentTime) {
                setScheduleToInvalid($schedId);
            }
        } else {
            setScheduleToInvalid($schedId);
        }
    }

    function setScheduleToInvalid($schedId) {
        $conn = connectDb();

        if(!doesSchedExist($schedId)) {
            date_default_timezone_set("Asia/Manila");
            $ToDate = substr($schedId, 0, 6);
            $month = substr($ToDate, 2, 2);
            $day = substr($ToDate, 4, 2);
            $year = substr($ToDate, 0, 2);
            $date = new DateTime($year . "-" . $month . "-" .$day);
            $dateToAdd = $date->format("Y-m-d");
            $officeToAdd = "RTU-O" . substr($schedId, 6, 2);
            $slotToAdd = "TMSLOT-" . substr($schedId, 8, 2);

            createSched($schedId, $dateToAdd, $slotToAdd, $officeToAdd); 
        }
        $stmt = $conn->prepare("UPDATE tbl_schedule SET sched_is_available = 0 WHERE sched_id = ?");
        $stmt->execute([$schedId]);
    }

    function getTimeSlotStart($timeCode) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT tmslot_start FROM tbl_timeslot WHERE tmslot_id = ?");
        $stmt-> execute([$timeCode]);
        $timeValue = $stmt->fetchColumn();

        // Catch if db fails 
        return $timeValue;
    }

    function getTimeSlotEnd($timeCode) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT tmslot_end FROM tbl_timeslot WHERE tmslot_id = ?");
        $stmt-> execute([$timeCode]);
        $timeValue = $stmt->fetchColumn();

        // Catch if db fails 
        return $timeValue;
    }

    function doesSchedExist($schedId) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_schedule WHERE sched_id = ?");
        $stmt-> execute([$schedId]);

        return $stmt->fetchColumn(); // Lacks Catch
    }

    function createSched($schedId, $date, $timeId, $office) {
        $conn = connectDb();

        $stmt = $conn -> prepare("INSERT INTO tbl_schedule (sched_id, tmslot_id, office_id, sched_date)
            VALUES (:schedno, :tmslot, :office, :sdate)");
        $stmt-> bindParam(':schedno', $schedId);
        $stmt-> bindParam(':tmslot', $timeId);
        $stmt-> bindParam(':office', $office);
        $stmt-> bindParam(':sdate', $date);

        return $stmt->execute(); 
    }

    function createAppointment($schedId, $vstor_id, $branch, $office, $purpose) {
        $conn = connectDb();

        addToSchedTotalVisitor($schedId);
        $current_queue = checkSchedTotalVisitor($schedId);
        $appId = $schedId . (string)$current_queue;

        // Generate random string then translate into hash to set as an unreadable key for the appointment 
        $randomString = generateRandomString();
        $appointmentKey = hash("sha256", $appId . $randomString);
        $qr_key = $appId . generateRandomString(6);

        $stmt = $conn -> prepare("INSERT INTO tbl_appointment_auth (app_id, app_key, f_key1, f_key2, qr_key) 
            VALUES (:appno, :appkey, :fkey, :fkeyy, :qr)");
        $stmt-> bindParam(':appno', $appId);
        $stmt-> bindParam(':appkey', $appointmentKey);
        $stmt-> bindParam(':fkey', generateRandomString());
        $stmt-> bindParam(':fkeyy', generateRandomString());
        $stmt-> bindParam(':qr', $qr_key);
        $submitResult = $stmt->execute();

        if(!$submitResult) {
            return false;
        }

        $date_r = new DateTime();
        $date = $date_r->format("Y-m-d H:i:s"); 

        $stmt = $conn -> prepare("INSERT INTO tbl_appointment (app_id, vstor_id, sched_id, office_id, app_branch, app_purpose, app_sys_time)
            VALUES (:appno, :vstor, :sched, :office, :branch, :purpose, :date)");
        $stmt-> bindParam(':appno', $appId);
        $stmt-> bindParam(':vstor', $vstor_id);
        $stmt-> bindParam(':sched', $schedId);
        $stmt-> bindParam(':office', $office);
        $stmt-> bindParam(':branch', $branch);
        $stmt-> bindParam(':purpose', $purpose);
        $stmt-> bindParam(':date', $date);

        setVisitorApp($vstor_id);
        $stmt->execute(); //Lacks Catch

        // Lacks: Dapat hindi mag save ng auth key pag pumalpak unang query ^

        return $appId;

        // Lacks checking if sched is still available
        
    }

    function checkSchedTotalVisitor($schedId) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT sched_total_visitor FROM tbl_schedule WHERE sched_id = ?");
        $stmt-> execute([$schedId]);

        $total_visitor = (int)$stmt->fetchColumn();
        return $total_visitor;
    }

    function addToSchedTotalVisitor($schedId) {
        $conn = connectDb();

        $stmt = $conn->prepare("UPDATE tbl_schedule SET sched_total_visitor = sched_total_visitor + 1 WHERE sched_id = ?");
        $stmt->execute([$schedId]);

        $stmt = $conn->prepare("UPDATE tbl_schedule SET sched_is_available = 0 WHERE sched_id = ? AND sched_total_visitor = ?");
        $stmt-> execute([$schedId, (int)max_per_sched]);
    }

    function checkDaySched($Day, $office) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_schedule WHERE (sched_date = ? AND office_id = ?) AND sched_is_available = 1");
        $stmt->execute([$Day, $office]);
        $total_ava_slots = $stmt->fetchColumn();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_schedule WHERE sched_date = ? AND office_id = ?");
        $stmt->execute([$Day, $office]);
        $total_slots = $stmt->fetchColumn();

        if($total_ava_slots > 0 || $total_slots < (int)number_of_timeslots) {
            return true;
        } else {
            return false;
        }
    }

    function setVisitorApp($vstor_id) {
        $conn = connectDb();
        $stmt = $conn->prepare("UPDATE tbl_visitor SET vstor_hasApp = TRUE WHERE vstor_id = ?");
        return $stmt->execute([$vstor_id]);
    }

    function doesUserMatch($userId, $lName, $userType) {
        $conn = connectDb();

        if($userType == "student") {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_visitor WHERE vstor_lname = ? AND vstor_id = (SELECT vstor_id FROM tbl_student_data WHERE student_num = ?)");
        } else if($userType == "employee") {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_visitor WHERE vstor_lname = ? AND vstor_id = (SELECT vstor_id FROM tbl_employee_data WHERE employee_num = ?)");
        } else if($userType == "guest"){
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_visitor WHERE vstor_lname = ? AND vstor_email = ?");
            
        } else {
            /// INTERNAL ERROR PAGE
        }
        $stmt-> execute([$lName, $userId]);
        return $stmt->fetchColumn();
    }
    
    function getVisitorDataByAppointmentId($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT * FROM tbl_visitor WHERE vstor_id =
            (SELECT vstor_id FROM tbl_appointment WHERE app_id = ?)");
        $stmt-> execute([$app_id]);
        $result = $stmt->fetch();

        return $result; // Lacks Catch
    }

    function getAppointmentDetails($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT * FROM tbl_appointment WHERE app_id = ?");
        $stmt-> execute([$app_id]);
        $result = $stmt->fetch();

        return $result; // Lacks Catch
    }

    function getAppointmentDetailsByEmail($v_email) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT app_id, sched_id, office_id, app_branch, app_purpose FROM tbl_appointment 
        WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = ?)");
        $stmt-> execute([$v_email]);
        $result = $stmt->fetch();

        return $result; // Lacks Catch
    }

    function isAppointmentDoneByEmail($v_email) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT app_is_done FROM tbl_appointment 
        WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = ?)");
        $stmt-> execute([$v_email]);
        $result = $stmt->fetchColumn();

        return $result;  // Lacks Catch
    }

    function getScheduleDetailsByAppointmentId($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT * FROM tbl_schedule WHERE sched_id = (SELECT sched_id FROM tbl_appointment WHERE app_id = ?)");
        $stmt-> execute([$app_id]);
        $result = $stmt->fetch();

        return $result; // Lacks Catch
    }

    function getOffices($branch) {
        $conn = connectDb();
        $result = [];

        $stmt = $conn->prepare("SELECT office_id, office_name FROM tbl_office WHERE office_branch = ?");
        $stmt-> execute([$branch]);

        while($row = $stmt->fetchAll()) {
            $result = array_merge($result, $row);
        }

        return $result; // Lacks Catch
    }
    
    function getAppointmentKeyByAppointmentId($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT app_key FROM tbl_appointment_auth WHERE app_id = ?");
        $stmt-> execute([$app_id]);
        $result = $stmt->fetchColumn();

        return $result;
    }
    function getAppointmentIdByAppointmentKey($app_key) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT app_id FROM tbl_appointment_auth WHERE app_key = ?");
        $stmt-> execute([$app_key]);
        $result = $stmt->fetchColumn();

        return $result;
    }
?>