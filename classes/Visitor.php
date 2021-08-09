<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    function getStudentDataById($visitor_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT student_num FROM tbl_student_data WHERE vstor_id = ?");
        $stmt->execute([$visitor_id]);

        return $stmt->fetchColumn();
    }

    function getEmployeeDataById($visitor_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT employee_num FROM tbl_employee_data WHERE vstor_id = ?");
        $stmt->execute([$visitor_id]);

        return $stmt->fetchColumn();
    }

    function getGuestDataById($visitor_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT government_id FROM tbl_guest_data WHERE vstor_id = ?");
        $stmt->execute([$visitor_id]);

        return $stmt->fetchColumn();
    }

    function getGuestNextDataById($visitor_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT company FROM tbl_guest_data WHERE vstor_id = ?");
        $stmt->execute([$visitor_id]);

        return $stmt->fetchColumn();
    }

    function setVisitorOpen($app_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("UPDATE tbl_visitor SET vstor_hasApp = 0 WHERE vstor_id = (SELECT vstor_id FROM tbl_appointment WHERE app_id = ?)");
        $result = $stmt->execute([$app_id]);

        return $result;
    }
?>