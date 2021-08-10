<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/module.php");

    function addAdminAccount($lname, $fname, $email, $contact, $pass, $office) {
        $conn = connectDb();
        if(!isOfficeUnassigned($office)) {
            return false;
        }
        $office_to_id = str_replace("O","",$office);
        $oadmn_id = $office_to_id . '-' . getNextAdminId();
        $stmt = $conn -> prepare("INSERT INTO tbl_office_admin (oadmn_id, oadmn_lname, office_id, oadmn_fname, oadmn_email, oadmn_contact)
            VALUES (:oadmn_num, :lname, :office, :fname, :email, :contact)");
        $stmt-> bindParam(':oadmn_num', $oadmn_id);
        $stmt-> bindParam(':lname', $lname);
        $stmt-> bindParam(':office', $office);
        $stmt-> bindParam(':fname', $fname);
        $stmt-> bindParam(':email', $email);
        $stmt-> bindParam(':contact', $contact);

        $result = $stmt->execute(); //Lacks Catch

        
        if($result) {
            setOfficeAsAssigned($office);
            return $oadmn_id;
        }
    }

    function addAdminAuth($oadmn_id, $pass) {
        $conn = connectDb();

        $gen_string = genString();
        $password = hash('sha256',$pass . $gen_string);
        $date = new DateTime();
        $submit_date = $date->format('Y-m-d H:i:s');

        $stmt = $conn -> prepare("INSERT INTO tbl_office_adm_auth (oadmn_id, oadmn_pass, oadmn_gen_string, oadmn_date_crtd)
            VALUES (:oadmn_id, :passw, :salt, :date_crtd)");
        $stmt-> bindParam(':oadmn_id', $oadmn_id);
        $stmt-> bindParam(':passw', $password);
        $stmt-> bindParam(':salt', $gen_string);
        $stmt-> bindParam(':date_crtd', $submit_date);

        $result = $stmt->execute();
        return $result;
    }

    function getNextAdminId() {
        $conn = connectDb();

        $stmt = $conn -> query("SELECT MAX(oadmn_num) FROM tbl_office_admin");
        $result = $stmt->fetchColumn();

        if($result) {
            return $result + 1;
        } else {
            return 10;
        }
        
    }

    function userIsAuthenticated($uname, $password) {
        $conn = connectDb();
        $gen_string = getUserGenString($uname);

        if(!$gen_string) {
            return false;
        }

        $final_password = hash('sha256',$password . $gen_string);
        $stmt = $conn -> prepare("SELECT COUNT(*) FROM tbl_office_adm_auth WHERE oadmn_id = :username AND oadmn_pass = :pword");
        $stmt-> bindParam(':username', $uname);
        $stmt-> bindParam(':pword', $final_password);
        $stmt-> execute();

        $result = $stmt-> fetchColumn();

        if($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    function doesUserHasData($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT COUNT(*) FROM tbl_office_admin WHERE oadmn_id = ?");
        $stmt->execute([$uname]);
        $result = $stmt->fetchColumn();

        if($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getUserGenString($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT oadmn_gen_string FROM tbl_office_adm_auth WHERE oadmn_id = ?");
        $stmt->execute([$uname]);
        $result = $stmt->fetchColumn();

        return $result;
    }

    function getLastPasswordChange($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT oadmn_pass_chng FROM tbl_office_adm_auth WHERE oadmn_id = ?");
        $stmt -> execute([$uname]);
        $result = $stmt->fetchColumn();

        return $result;
    }

    function isPasswordValid($uname, $chng_key) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT COUNT(*) FROM tbl_office_adm_auth WHERE oadmn_id = :username AND oadmn_pass_chng = :chng");
        $stmt-> bindParam(':username', $uname);
        $stmt-> bindParam(':chng', $chng_key);
        $stmt-> execute();

        $result = $stmt-> fetchColumn();

        if($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getFullName($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT CONCAT(oadmn_fname, ' ', oadmn_lname) FROM tbl_office_admin WHERE oadmn_id = ?");
        $stmt -> execute([$uname]);
        $result = $stmt->fetchColumn();

        return $result;
    }

    function getFirstName($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT oadmn_fname FROM tbl_office_admin WHERE oadmn_id = ?");
        $stmt -> execute([$uname]);
        $result = $stmt->fetchColumn();

        return $result;
    }

    function getAssignedOffice($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT office_id FROM tbl_office_admin WHERE oadmn_id = ?");
        $stmt -> execute([$uname]);
        $result = $stmt->fetchColumn();

        return $result;
    }

    function getAdminData($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT oadmn_id, oadmn_lname, oadmn_fname, oadmn_email, oadmn_contact FROM tbl_office_admin WHERE oadmn_id = ?");
        $stmt -> execute([$uname]);
        $result = $stmt->fetch();

        return $result;
    }

    function doesAdminHasUpload($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT COUNT(*) FROM tbl_office_upld WHERE oadmn_id = :username");
        $stmt-> bindParam(':username', $uname);
        $stmt-> execute();

        $result = $stmt-> fetchColumn();

        if($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateData($uname, $firstname, $lastname, $email, $phone) {
        $conn = connectDb();

        $stmt = $conn -> prepare("UPDATE tbl_office_admin SET oadmn_lname = ?, oadmn_fname = ?, oadmn_email = ?, oadmn_contact = ? WHERE oadmn_id = ?");
        
        return $stmt -> execute([$lastname, $firstname, $email, $phone, $uname]);
    }

    function changeAdminPassword($uname, $pass) {
        $conn = connectDb();

        $gen_string = genString();
        $password = hash('sha256', $pass . $gen_string);
        $date = new DateTime();
        $submit_date = $date->format('Y-m-d H:i:s');

        $stmt = $conn -> prepare("UPDATE tbl_office_adm_auth SET oadmn_pass = ?, oadmn_gen_string = ?, oadmn_pass_chng = ? WHERE oadmn_id = ?");
        
        return $stmt->execute([$password, $gen_string, $submit_date, $uname]);
    }
?>