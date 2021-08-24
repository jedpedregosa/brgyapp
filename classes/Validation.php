<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    function validateTime($date, $format = 'H:i')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    function validateTimeSlotId($tmslot_id) {
        $conn = connectDb();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_timeslot WHERE tmslot_id = ?");
        $stmt->execute([$tmslot_id]);
        
        return $stmt->fetchColumn();
    }

    function secureStringValidation($str, $minLength = 8, $maxLength = 18) {
        $uppercase = preg_match('@[A-Z]@', $str);
        $lowercase = preg_match('@[a-z]@', $str);
        $number = preg_match('@[0-9]@', $str);
        $specialChars = preg_match('@[^\w]@', $str);

        if(!$uppercase || !$lowercase || !$number || !$str || strlen($str) < $minLength || strlen($str) > $maxLength) {
            return false;
        }

        return true;
    }
    function valid_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }

    function lengthValidation($data, $min, $max) {
        if(strlen($data) >= $min && strlen($data) <= $max) {
            return true;
        } else {
            return false;
        }
    }

    function valid_campus($data) {
        if($data != "Boni Campus" && $data != "Pasig Campus") {
            return false;
        } 
        return true;
    }
?>