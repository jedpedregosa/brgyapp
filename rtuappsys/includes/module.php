<?php 
    function isTypeValid($uType) {
        return $uType == "student" ? true : $uType == "employee" ? true : $uType == "guest" ? true : false;
    }

    // Requests

?>