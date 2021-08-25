<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    /* LOG TYPES
     *
     *  TYPE 1 - View Appointment Access Request Failed
     *  TYPE 2 - View Appointment Access Request Success
     *  TYPE 3 - Office Admin Access Request Failed
     *  TYPE 4 - Office Admin Access Request Success
     *  TYPE 5 - Config Admin Access Request Failed
     *  TYPE 6 - Config Admin Access Request Success
     *  TYPE 7 - Office Admin End Session
     *  TYPE 8 - Config Admin End Session
     *  TYPE 9 - Maintenance Mode
     *  TYPE A - System Variable Changes
     *  TYPE B - System Reset
     *  TYPE C - Office Admin Account Locked
     *  TYPE D - Config Admin Account Locked
     */

    function createLog($name, $type, $source) {
        $conn = connectDb();

        $date_r = new DateTime();
        $date = $date_r->format("Y-m-d H:i:s");

        $stmt = $conn->prepare("INSERT INTO tbl_config_log (log_tmstmp, log_type, log_owner, log_source)
            VALUES (?, ?, ?, ?)");
        
        return $stmt->execute([$date, $type, $name, $source]);
    }

    function getAllSysLog($isMonth = false) {
        $conn = connectDb();

        $stmt;

        if($isMonth) {
            $last_month = date("Y-m-d", strtotime("-30 day"));

            $stmt = $conn->prepare("SELECT * FROM tbl_config_log WHERE log_tmstmp > ? ORDER BY log_tmstmp DESC");
            $stmt->execute([$last_month]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM tbl_config_log ORDER BY log_tmstmp DESC");
            $stmt->execute();
        }
        
        $all_logs = [];
        while($row = $stmt->fetchAll()) {
            $all_logs = array_merge($all_logs, $row);
        }

        $i = 0;
        for($i = 0; $i < sizeof($all_logs); $i++) {
            $msg;

            switch($all_logs[$i][2]) {
                case "1":
                    $msg = " tried to access an appointment at ";
                    break;
                case "2":
                    $msg = " viewed an appointment at ";
                    break;
                case "3":
                    $msg = " tried to log in an office admin account at ";
                    break;
                case "4":
                    $msg = " [OFFICE_ADMIN] logged <strong>in</strong> at ";
                    break;
                case "5":
                    $msg = " tried to log in a config admin account at ";
                    break;
                case "6":
                    $msg = " [SYS_ADMIN] logged <strong>in</strong> at ";
                    break;
                case "7":
                    $msg = " [OFFICE_ADMIN] logged <strong>out</strong> at ";
                    break;
                case "8":
                    $msg = " [SYS_ADMIN] logged <strong>out</strong> at ";
                    break;
                case "9":
                    $msg = " [SYS_ADMIN] <strong>changed the maintenance status at</strong> ";
                    break;
                case "A":
                    $msg = " [SYS_ADMIN] <strong>changed the system variable at</strong> ";
                    break;
                case "B":
                    $msg = " <strong>--- ADMIN CONFIGURATION RESET ---</strong> ";
                    break;
                case "C":
                    $msg = " [OFFICE_ADMIN] <strong>account locked</strong> at";
                    break;
                case "D":
                    $msg = " [CONFIG_ADMIN] <strong>account locked</strong> at";
                    break;
                default:
                    $msg = " <strong>------------------</strong> ";
            }
            $all_logs[$i][2] = $msg;
        }

        return $all_logs;
    }
?>