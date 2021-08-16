<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    function getUnassignedOffices($branch) {
        $conn = connectDb();
        $result = [];

        $stmt = $conn->prepare("SELECT office_id, office_name FROM tbl_office WHERE office_branch = ? AND office_hasAdmin = 0
            ORDER BY office_name ASC");
        $stmt-> execute([$branch]);

        while($row = $stmt->fetchAll()) {
            $result = array_merge($result, $row);
        }

        return $result; // Lacks Catch
    }

    function setOfficeAsAssigned($office) {
        $conn = connectDb();

        $stmt = $conn->prepare("UPDATE tbl_office SET office_hasAdmin = 1 WHERE office_id = ?");
        $stmt-> execute([$office]);

    }

    function isOfficeUnassigned($office) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_hasAdmin FROM tbl_office WHERE office_branch = ?");
        $stmt-> execute([$office]);

        $result = $stmt->fetchColumn();

        return !$result; // Lacks Catch
    }

    function getOfficeName($office) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_name FROM tbl_office WHERE office_id = ?");
        $stmt-> execute([$office]);

        $result = $stmt->fetchColumn();

        return $result;
    }
    
    function getCampusName($office) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_branch FROM tbl_office WHERE office_id = ?");
        $stmt-> execute([$office]);

        $result = $stmt->fetchColumn();

        return $result;
    }
    function loadAllOffice() {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_id, office_name, office_branch FROM tbl_office 
            WHERE accepts_app = 1 ORDER BY office_name ASC");
        $stmt->execute();

        $offices = [];
        while($row = $stmt->fetchAll()) {
            $offices = array_merge($offices, $row);
        }

        return $offices;
    }

    function doesOfficeExist($office) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_office WHERE office_id = ?");
        $stmt->execute([$office]);

        $result = $stmt->fetchColumn();

        if((int)$result > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getAllOffice() {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_id, office_name, office_desc, office_branch, accepts_app
            FROM tbl_office ORDER BY office_id ASC"); // Change here if includes has_Admin
        $stmt->execute();

        $offices = [];
        while($row = $stmt->fetchAll()) {
            $offices = array_merge($offices, $row);
        }

        return $offices;
    }

    function getAllOfficeAdmin() {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_id, oadmn_id, oadmn_lname, oadmn_fname, oadmn_email, oadmn_contact
            FROM tbl_office_admin ORDER BY office_id ASC"); // Change here if includes has_Admin
        $stmt->execute();

        $offices = [];
        while($row = $stmt->fetchAll()) {
            $offices = array_merge($offices, $row);
        }

        return $offices;
    }

    function getNextOfficeId() {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT MAX(office_num) FROM tbl_office");
        $stmt->execute();

        $nextId = (int)$stmt->fetchColumn() + 1;

        if($nextId < 10) {
            $nextId = str_pad($nextId, 2, '0', STR_PAD_LEFT);
        }
        return $nextId;
    }

    function createOffice($off_name, $off_camp, $off_desc, $off_accepts) {
        $conn = connectDb();

        $office_id = "RTU-O" . getNextOfficeId();

        $stmt = $conn->prepare("INSERT INTO tbl_office (office_id, office_name, office_desc,
            office_branch, accepts_app) VALUES (?,?,?,?,?)");
        $result = $stmt->execute([$office_id, $off_name, $off_desc, $off_camp, $off_accepts]);

        if($result) {
            return $office_id;
        } else {
            return $result;
        }
    }
?>