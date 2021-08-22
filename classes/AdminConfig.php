<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/module.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/SystemLog.php");

    function configSysReset($config_admin_detail) {
        $conn = connectDb();

        $reset_result = true;

        $stmt = $conn->prepare("TRUNCATE tbl_config_admin");
        $reset_result = $stmt->execute();

        foreach($config_admin_detail as $admin) {
            $admin_id = $admin[0];
            $gen_string = genString();
            $password = hash('sha256', $admin[1] . $gen_string);

            $stmt = $conn->prepare("INSERT INTO tbl_config_admin 
                (admn_id, admn_pass, admn_gen_str, admn_pass_chng, admn_is_lckd) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([$admin_id, $password, $gen_string, 'UNDEFINED', 0]);  
            
            $reset_result = $reset_result  && $result;
        }

        createLog("[SYS_ADMIN]", "B", USER_IP);

        return $reset_result;
    }

    function configIsAuthenticated($uname, $password) {
        $conn = connectDb();
        $gen_string = getConfigGenString($uname);

        if(!$gen_string) {
            return false;
        }

        $final_password = hash('sha256',$password . $gen_string);
        $stmt = $conn -> prepare("SELECT COUNT(*) FROM tbl_config_admin WHERE admn_id = :username AND admn_pass = :pword");
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
    function configLastPasswordChange($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT admn_pass_chng FROM tbl_config_admin WHERE admn_id = ?");
        $stmt -> execute([$uname]);
        $result = $stmt->fetchColumn();

        return $result;
    }

    function getConfigGenString($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT admn_gen_str FROM tbl_config_admin WHERE admn_id = ?");
        $stmt->execute([$uname]);
        $result = $stmt->fetchColumn();

        return $result;
    }

    function doesConfigAdminExist($uname) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT COUNT(*) FROM tbl_config_admin WHERE admn_id = ?");
        $stmt -> execute([$uname]);
        $result = $stmt->fetchColumn();

        if($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    function isConfigPasswordValid($uname, $chng_key) {
        $conn = connectDb();

        $stmt = $conn -> prepare("SELECT COUNT(*) FROM tbl_config_admin WHERE admn_id = :username AND admn_pass_chng = :chng");
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

    function addConfigAttempt($username) {
        $conn = connectDb();

        $stmt = $conn->prepare("INSERT INTO tbl_config_attmp (admn_id, attmp_stmp, attmp_ip)
            VALUES (?, ?, ?)");
        $result = $stmt->execute([$username, time(), USER_IP]);

        if(isBlocked($username)) {
            createLog($username, "D", USER_IP);
        }
        return $result;
    }

    function isBlocked($username) {
        $conn = connectDb();

        $hour_ago = time() - 3600;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_config_attmp WHERE admn_id = ? AND attmp_stmp > ?");
        $stmt->execute([$username, $hour_ago]);

        $result = (int)$stmt->fetchColumn();

        if($result < max_attmp_per_hour) {
            return false;
        } else {
            return true;
        }
    }

    function deleteAllAttempt($username) {
        $conn = connectDb();

        $stmt = $conn->prepare("DELETE FROM tbl_config_attmp WHERE admn_id = ?");
        $stmt->execute([$username]);
    }

    function changeConfigUsername($uname, $new_uname) {
        $conn = connectDb();

        $stmt = $conn->prepare("UPDATE tbl_config_admin SET admn_id = ? WHERE admn_id = ?");
        $result = $stmt->execute([$new_uname, $uname]);

        return $result;
    }

    function changeConfigPassword($uname, $new) {
        $conn = connectDb();

        $gen_string = genString();
        $password = hash('sha256', $new . $gen_string);

        $stmt = $conn->prepare("UPDATE tbl_config_admin SET admn_pass = ?, admn_gen_str = ?, admn_pass_chng = ?  WHERE admn_id = ?");
        $result = $stmt->execute([$password, $gen_string, time(), $uname]);

        return $result;
    }

    function getAllConfig() {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT * FROM tbl_config_var ORDER BY config_attrb ASC LIMIT 1");
        $stmt->execute();

        return $stmt->fetch();
    }

    function updateSystemStatus($main_status) {
        $conn = connectDb();

        $stmt = $conn->prepare("UPDATE tbl_config_var SET is_in_maintenance = ? WHERE config_attrb = 1");
        
        return $stmt->execute([$main_status]);
    }

    function isUnderMaintenance() {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT is_in_maintenance FROM tbl_config_var ORDER BY config_attrb ASC LIMIT 1");
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    function updateSystemVariables($max_visitor, $day_span, $hours_span, $day_rsched) {
        $conn = connectDb();

        $stmt = $conn->prepare("UPDATE tbl_config_var SET max_per_sched = ?, days_resched_span = ?,
            hour_sched_span = ?, days_sched_span = ? WHERE config_attrb = 1");
        $result = $stmt->execute([$max_visitor, $day_rsched, $hours_span, $day_span]);

        return $result;
    }
?>