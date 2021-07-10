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
            return FALSE;
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
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_visitor WHERE vstor_email = ?");
            $stmt-> execute([$userID]);
        }
        //// Other User Types on Else-ifs
        $result = $stmt->fetchColumn(); // Lacks checker if db fails (to error page)

        return $result;
    }

    function getUserData($userID, $userType) {
        $conn = connectDb();
        $stmt = null;
        $result = null;
        
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
        }
        //// Other User Types on Else-ifs
        $result = $stmt->fetchColumn(); // Lacks checker if db fails (to error page)

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
        $stmt-> bindParam(':phone', $userData[3]);
        $stmt-> bindParam(':email', $userData[0]);
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
            $stmt-> bindParam(':company', $userData[4]);
            $stmt-> bindParam(':govId', $userData[5]);
        }

        $secondReq = $stmt->execute(); // Lacks checker if db fails (to error page)

        return $firstReq && $secondReq;
    }

?>