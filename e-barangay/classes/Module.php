<?php 
    function getTimeDate($format) {
        $today = new DateTime();

        return $today->format($format);
    }

    function transformDate($date, $format) {
        $date = new DateTime($date);

        return $date->format($format);
    }

    function generateRandomString(
        int $length = 12,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }

    function getCivilStatus($status) {
        switch($status) {
            case 1: 
                return "Single";
                break;
            case 2: 
                return "Married";
                break;
            case 3:
                return "Divorced";
                break;
            case 4:
                return "Seperated";
                break;
            case 5:
                return "Widowed";
                break;
            default:
                return "Single";
        }
    }

    function isImageValid($file) {
        if($file['size'] > 10485760) { //10 MB (size is also in bytes)
            return false;
        }

        /* Process image with GD library */
        $verify_img = getimagesize($file['tmp_name']);

        /* Make sure the MIME type is an image */
        $pattern = "#^(image/)[^\s\n<]+$#i";
        
        if(!preg_match($pattern, $verify_img['mime'])){
            return false;
        }
        
        return true;
    }

    function isFileValid($file) {
        if($file['size'] > 10485760 * 20) { //20 MB (size is also in bytes)
            return false;
        }

        switch($file["type"]) {
            case 'application/msword': 
                return true;
                break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                return true;
                break;
            case 'application/pdf':
                return true;
                break;
            default:
                return false;
        }
    }

?>