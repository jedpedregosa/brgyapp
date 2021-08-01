<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    function getUnassignedOffices($branch) {
        $conn = connectDb();
        $result = [];

        $stmt = $conn->prepare("SELECT office_id, office_name FROM tbl_office WHERE office_branch = ? AND office_hasAdmin = 0");
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
    
?>