<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");

    function saveFeedback($fname, $cat, $contact, $office, $email, $feedback, $isSatisfied, $ip) {
        $conn = connectDb();

        $office_name = getOfficeName($office) . ", " . getCampusName($office);
        $date_r = new DateTime();
        $date = $date_r->format("Y-m-d H:i:s");

        $stmt = $conn -> prepare("INSERT INTO tbl_feedback 
            (fback_fname, fback_cat, fback_contact, office_id, office_name, fback_email, fback_msg, fback_sys_time, fback_is_stsfd, fback_ip_add)
            VALUES (:fname, :catgry, :contact, :office, :oname, :email, :msg, :systime, :stsfd, :ip)");
        $stmt->bindParam(":fname", $fname);
        $stmt->bindParam(":catgry", $cat);
        $stmt->bindParam(":contact", $contact);
        $stmt->bindParam(":office", $office);
        $stmt->bindParam(":oname", $office_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":msg", $feedback);
        $stmt->bindParam(":systime", $date);
        $stmt->bindParam(":stsfd", $isSatisfied);
        $stmt->bindParam(":ip", $ip);

        $result = $stmt->execute();

        return $result;
    }

    function getAllFeedBack($office = null, $isMonth = false) {
        $conn = connectDb();

        $feedback = [];

        $stmt; 

        if(!empty($office)) {
            if($isMonth) {
                $last_month = date("Y-m-d", strtotime("-30 day"));

                $stmt = $conn->prepare("SELECT fback_fname, fback_contact, fback_email, fback_msg, fback_cat, fback_sys_time, fback_is_stsfd 
                    FROM tbl_feedback WHERE office_id = ? AND fback_sys_time > ? ORDER BY fback_id DESC LIMIT 50");
                $stmt->execute([$office, $last_month]);
            } else {
                $stmt = $conn->prepare("SELECT fback_fname, fback_contact, fback_email, fback_msg, fback_cat, fback_sys_time, fback_is_stsfd 
                    FROM tbl_feedback WHERE office_id = ? ORDER BY fback_id DESC LIMIT 50");
                $stmt->execute([$office]);
            }      
        } else {
            if($isMonth) {
                $last_month = date("Y-m-d", strtotime("-30 day"));

                $stmt = $conn->prepare("SELECT office_id, fback_fname, fback_contact, fback_email, fback_msg, fback_cat, fback_sys_time, fback_is_stsfd,
                    fback_ip_add FROM tbl_feedback WHERE fback_sys_time > ? ORDER BY fback_id DESC LIMIT 50");
                $stmt->execute([$last_month]);
            } else {
                $stmt = $conn->prepare("SELECT office_id, fback_fname, fback_contact, fback_email, fback_msg, fback_cat, fback_sys_time, fback_is_stsfd,
                    fback_ip_add FROM tbl_feedback ORDER BY fback_id DESC LIMIT 50");
                $stmt->execute();
            }
        }
        

        while($row = $stmt->fetchAll()) {
            $feedback = array_merge($feedback, $row);
        }

        return $feedback;
    }

    function downloadAllFeedBack($office = null, $isMonth = false) {
        $conn = connectDb();

        $feedback = [];

        $stmt; 

        if(!empty($office)) {
            if($isMonth) {
                $last_month = date("Y-m-d", strtotime("-30 day"));

                $stmt = $conn->prepare("SELECT fback_fname, fback_contact, fback_email, fback_msg, fback_cat, fback_sys_time, fback_is_stsfd 
                    FROM tbl_feedback WHERE office_id = ? AND fback_sys_time > ? ORDER BY fback_id DESC");
                $stmt->execute([$office, $last_month]);
            } else {
                $stmt = $conn->prepare("SELECT fback_fname, fback_contact, fback_email, fback_msg, fback_cat, fback_sys_time, fback_is_stsfd 
                    FROM tbl_feedback WHERE office_id = ? ORDER BY fback_id DESC");
                $stmt->execute([$office]);
            }      
        } else {
            if($isMonth) {
                $last_month = date("Y-m-d", strtotime("-30 day"));

                $stmt = $conn->prepare("SELECT office_id, fback_fname, fback_contact, fback_email, fback_msg, fback_cat, fback_sys_time, fback_is_stsfd,
                    fback_ip_add FROM tbl_feedback WHERE fback_sys_time > ? ORDER BY fback_id DESC");
                $stmt->execute([$last_month]);
            } else {
                $stmt = $conn->prepare("SELECT office_id, fback_fname, fback_contact, fback_email, fback_msg, fback_cat, fback_sys_time, fback_is_stsfd,
                    fback_ip_add FROM tbl_feedback ORDER BY fback_id DESC");
                $stmt->execute();
            }
        }
        

        while($row = $stmt->fetchAll()) {
            $feedback = array_merge($feedback, $row);
        }

        return $feedback;
    }

    function getTwoFeedBack($office = null) {
        $conn = connectDb();

        $feedback = [];

        
        $stmt;

        if(!empty($office)) {
            $stmt = $conn->prepare("SELECT fback_fname, fback_contact, fback_email, fback_msg, office_name, fback_cat, fback_sys_time, fback_is_stsfd 
                FROM tbl_feedback WHERE office_id = ? ORDER BY fback_id DESC, fback_sys_time desc LIMIT 2");
            $stmt->execute([$office]);
        } else {
            $stmt = $conn->prepare("SELECT fback_fname, fback_contact, fback_email, fback_msg, office_name, fback_cat, fback_sys_time, fback_is_stsfd 
                FROM tbl_feedback ORDER BY fback_id DESC, fback_sys_time desc LIMIT 2");
            $stmt->execute();
        }

        while($row = $stmt->fetchAll()) {
            $feedback = array_merge($feedback, $row);
        }

        return $feedback;
    }
?>