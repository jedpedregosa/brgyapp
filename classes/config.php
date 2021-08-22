<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		config.php (Class, Method Package) -- 
 *  Description:
 * 		1. Contains all defined values that the overall system requires.
 * 
 * 	Date Created: 14th of August, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	
 *  Lacks: 
 *  Changes:
 * 	
 *  Information:
 *      FOR: Development Hosting (InfinityFree)
        
        Username: epiz_29135999
        Password: eeuVG3nI1FktBwq
        Name: epiz_29135999_rtuappsysdb
        Host: sql103.epizy.com
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 ******************************************************************************/
    
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/AdminConfig.php");

    define("db_host", "localhost");
    define("db_user", "rtuappsys");
    define("db_pw", "rtusysapppw");
    define("db_name", "rtuappsysdb");

    define("HTTP_PROTOCOL", "http://");      /* Change to "HTTPS" If using an SSL */
    define('HOST', $_SERVER["HTTP_HOST"]);   /* Returns the current domain name */
    define("FILE_VERSION", "?v=1");          /* File versioning for all files (JavaScript and CSS) */
    define("APP_FILES", $_SERVER['DOCUMENT_ROOT'] . "/files/APPOINTMENT_FILE/");
    /* Secure Directory of all system generated files */

    define("max_attmp_per_hour", 5);
    define("max_attmp_per_halfhour", 10);
    
    define("config_min_session_expr", 5);        // Log out system admin if there is no activity within 5 minutes.
    define("oadmin_min_session_expr", 60 * 5);   // Log out office admin if there is no activity within 300 minutes.


    define("number_of_timeslots", 15);      /* DO NOT TOUCH */
    
    $config_vals = getAllConfig();

    define("max_per_sched", $config_vals[1]);             /* This limits the visitor for each schedule */
    define("days_scheduling_span", $config_vals[4]);     /* This sets the span of dates that are available for appointments */
    define("hours_scheduling_span", $config_vals[3]);     /* This sets the span of hour applicable for slots on same day appointments */
    define("days_rescheduling_span", $config_vals[1]);    /* This sets the span of days required for a reschedule */

    define("sys_in_maintenance", $config_vals[5]);

    define("IS_AJAX", (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'));
    define("USER_IP", (isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDE‌​D_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR']));


?>
