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
            if(doesUserExists($userData[3], "guest")) {
                // If the old email owner is in the database, delete visitor + data then update the user type.
                delUserByEmail($userData[3], $oldEmailOwnerType);
            } else if (!doesUserExists($userData[3], "guest")) {
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
                $stmt-> bindParam(':email', $userId);
                if(!$stmt->execute()) {
                    // Dbase Query Error Page
                    return false;
                }

                
            $stmt = $conn->prepare("DELETE FROM tbl_visitor WHERE vstor_email = :email");
            $stmt-> bindParam(':email', $userId;
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            } 
        } else if($userType == "employee") {
            $stmt = $conn->prepare("DELETE FROM tbl_employee_data WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = :email)");
            $stmt-> bindParam(':email', $userId);
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            }

            $stmt = $conn->prepare("DELETE FROM tbl_visitor WHERE vstor_email = :email");
            $stmt-> bindParam(':email', $userId);
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            }
        } else if($userType == "student") {
            $stmt = $conn->prepare("DELETE FROM tbl_student_data WHERE vstor_id = (SELECT vstor_id FROM tbl_visitor WHERE vstor_email = :email)");
            $stmt-> bindParam(':email', $userId);
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            }

            $stmt = $conn->prepare("DELETE FROM tbl_visitor WHERE vstor_email = :email");
            $stmt-> bindParam(':email', $userId);
            if(!$stmt->execute()) {
                // Dbase Query Error Page
                return false;
            }
        }
    }
?>