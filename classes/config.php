<?php 
    /* 
        Development Hosting (InfinityFree)
        
        Username: epiz_29135999
        Password: eeuVG3nI1FktBwq
        Name: epiz_29135999_rtuappsysdb
        Host: sql103.epizy.com

    */
    define("db_host", "localhost");
    define("db_user", "rtuappsys");
    define("db_pw", "rtusysapppw");
    define("db_name", "rtuappsysdb");

    define("HTTP_PROTOCOL", "http://");      //Change to "HTTPS" If using an SSL
    define('HOST', $_SERVER["HTTP_HOST"]);  
    define("FILE_VERSION", "?v=1");
    define("APP_FILES", $_SERVER['DOCUMENT_ROOT'] . "/files/APPOINTMENT_FILE/");

    define("max_per_sched", 5);
    define("number_of_timeslots", 15);      /* DO NOT TOUCH */
    define("days_scheduling_span", 30);
    define("hours_scheduling_span", 2);
    define("days_rescheduling_span", 1);

    define("IS_AJAX", (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'));
    define("USER_IP", (isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDE‌​D_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR']));
?>
