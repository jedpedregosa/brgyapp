<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/config.php");

    function connectDb() {
        $conn;
        try {
            $conn = new PDO("mysql:host=localhost;dbname=" . db_name, db_user, db_pw);
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

        $stmt = $conn->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'rtuappsysdb' AND TABLE_NAME = 'tbl_visitor'");
        $user = $stmt->fetchColumn(); 

        return $user;
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
        if($total_visitor < (int)max_per_sched) {
            return true;
        } else {
            return false;
        }
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

        $stmt = $conn -> prepare("INSERT INTO tbl_appointment (app_id, vstor_id, sched_id, office_id, app_branch, app_purpose)
            VALUES (:appno, :vstor, :sched, :office, :branch, :purpose)");
        $stmt-> bindParam(':appno', $appId);
        $stmt-> bindParam(':vstor', $vstor_id);
        $stmt-> bindParam(':sched', $schedId);
        $stmt-> bindParam(':office', $office);
        $stmt-> bindParam(':branch', $branch);
        $stmt-> bindParam(':purpose', $purpose);

        setVisitorApp($vstor_id);
        $stmt->execute(); //Lacks Catch

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
        return $stmt->execute([$schedId]);
    }

    function setVisitorApp($vstor_id) {
        $conn = connectDb();
        $stmt = $conn->prepare("UPDATE tbl_visitor SET vstor_hasApp = TRUE WHERE vstor_id = ?");
        return $stmt->execute([$vstor_id]);
    }
?>