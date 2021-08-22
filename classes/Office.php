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

        $stmt = $conn->prepare("SELECT office_id, tbl_office_admin.oadmn_id, oadmn_lname, oadmn_fname, oadmn_email, oadmn_contact, tbl_office_adm_auth.oadmn_date_crtd
            FROM tbl_office_admin LEFT JOIN tbl_office_adm_auth ON tbl_office_adm_auth.oadmn_id = tbl_office_admin.oadmn_id ORDER BY tbl_office_admin.oadmn_id ASC"); // Change here if includes has_Admin
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

        /*
        !!! Must set information_schema_stats_expiry = 0 to use

        $stmt = $conn->prepare("SHOW TABLE STATUS LIKE 'tbl_office'");
        $stmt->execute();

        $col = $stmt->fetch();
        $last_insert = $col['Auto_increment'];

        $id = (int)$last_insert + 1;*/

        
        $id = (int)$stmt->fetchColumn() + 1;
        $next_id = base_convert(strval($id), 10, 36);
        if(strlen($next_id) < 2) {
            $next_id = str_pad($next_id, 2, '0', STR_PAD_LEFT);
        }
        return strtoupper($next_id);
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

    function doesOfficeHasApp($office_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointment WHERE office_id = ?");
        $stmt->execute([$office_id]);

        $result = (int)$stmt->fetchColumn();

        return ($result > 0); 
    }

    function getAdminIdByOffice($office_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT oadmn_id FROM tbl_office_admin WHERE office_id = ?");
        $stmt->execute([$office_id]);

        return $stmt->fetchColumn();
    }

    function deleteOffice($office_id) {
        $conn = connectDb(); 

        if(doesOfficeHasApp($office_id)) {
            return 301;
        } else {
            $stmt = $conn->prepare("DELETE FROM tbl_office WHERE office_id = ?");
            $stmt->execute([$office_id]);
            $result = boolval($stmt->rowCount());

            if($result) {
                $admin_id = getAdminIdByOffice($office_id);
                if(deleteOfficeAdmin($admin_id)) {
                    return $admin_id;
                } else {
                    return 300;
                }    
            } else {
                return false;
            }
        }
    }

    function deleteOfficeAdmin($admin_id) {
        $conn = connectDb(); 
        
        $office_id = getOfficeIdByAdmin($admin_id);

        $stmt = $conn->prepare("DELETE FROM tbl_office_admin WHERE oadmn_id = ?");
        $stmt->execute([$admin_id]);
        $admin_res = boolval($stmt->rowCount());

        $stmt = $conn->prepare("DELETE FROM tbl_office_adm_auth WHERE oadmn_id = ?");
        $stmt->execute([$admin_id]);
        $auth_res = boolval($stmt->rowCount());

        $stmt = $conn->prepare("DELETE FROM tbl_office_upld WHERE oadmn_id = ?");
        $stmt->execute([$admin_id]);

        if(boolval($office_id)) {
            $res = setOfficeAsUnassigned($office_id);

            return $admin_res && $auth_res && $res; 
        }
        return $admin_res && $auth_res;
    }

    function getOfficeIdByAdmin($admin_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT office_id FROM tbl_office_admin WHERE oadmn_id = ?");
        $stmt->execute([$admin_id]);

        return $stmt->fetchColumn();
    }

    function setOfficeAsUnassigned($office_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("UPDATE tbl_office SET office_hasAdmin = 0 WHERE office_id = ?");

        return $stmt->execute([$office_id]);
    }

    function updateOfficeData($office_id, $name, $desc, $accepts) {
        $conn = connectDb();

        $branch = getCampusName($office_id);

        if($branch) {
            if(validateOffice($name, $branch, $office_id)) {
                $stmt = $conn->prepare("UPDATE tbl_office SET office_name = ?, office_desc= ?, accepts_app = ?
                    WHERE office_id = ?");
                $result = $stmt->execute([$name, $desc, $accepts, $office_id]);

                if($result) {
                    return 300;
                } else {
                    return 302;
                }
            } else {
                return 301;
            }
        } else {
            return 302;
        }
    }

    function validateOffice($name, $campus, $office_id = null) {
        $conn = connectDb();


        if(empty($office_id)) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_office WHERE office_branch = ? AND office_name = ?");
            $stmt->execute([$campus, $name]);
        } else {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_office 
                WHERE (office_branch = ? AND office_name = ?) AND office_id != ?");
            $stmt->execute([$campus, $name, $office_id]);
        }
        $result = $stmt->fetchColumn();

        return !boolval($result);
    }
?>