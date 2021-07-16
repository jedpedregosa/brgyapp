<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/config.php");

    date_default_timezone_set("Asia/Manila");
    $ToDate = substr("2107150105", 0, 6);
    $month = substr($ToDate, 2, 2);
    $day = substr($ToDate, 4, 2);
    $year = substr($ToDate, 0, 2);
    $date = new DateTime($year . "-" . $month . "-" .$day);
    echo $date->format("Y-m-d");
    //echo substr("2107150105", 6, 2);

    //echo substr("2107150105", 8, 2);
    
?>