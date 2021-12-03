<?php 

/*  Config.php
*      Contains all default system variables.
*/

    // Database User

    # For Cloud Hosting 

    /* 
    define("dbHost", "sql100.epizy.com");
    define("dbUser", "epiz_30176699");
    define("dbPword", "SA2DFxD1u1iZ2");
    define("dbName", "epiz_30176699_dbbrgy108z12");
    */

    # For Local Use

    /* */
    define("dbHost", "localhost");
    define("dbUser", "eBrgy108Z12");
    define("dbPword", "eBrgy108Zone12");
    define("dbName", "dbbrgy108z12");
    /* */
    
    // Request Check

    # If request is from AJAX
    define("IS_AJAX", (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'));

    # Get user IP
    define("USER_IP", (isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDE‌​D_FOR']))?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR']);

    // System Variables
    define("admin_max_attempt", 10); # Max attempt per hour for admin
    define("resident_max_attempt", 5); # Max attempt per 30 min. for resident
    define("res_max_attempt", 5); # Max attempt per 15 min. for residents

    # Test Data
    $covid_data = array(
        "total"=> 97,
        "active"=> 0,
        "recovered"=> 95,
        "death"=> 2
    );

?>