<?php 
    /* 
        Sample Development Hosting (InfinityFree)
        
        Username: epiz_29135999
        Password: eeuVG3nI1FktBwq
        Name: epiz_29135999_rtuappsysdb
        Host: sql103.epizy.com

    */
    define("db_host", "localhost");
    define("db_user", "rtuappsys");
    define("db_pw", "rtusysapppw");
    define("db_name", "rtuappsysdb");

    define("max_per_sched", 5);
    define("number_of_timeslots", 15);
    define("days_scheduling_span", 30);
    define("hours_scheduling_span", 2);

    define("IS_AJAX", isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
?>