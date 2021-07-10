<?php 

/////////////// SOURCE CODE TESTING PAGE 
/// DELETE test.php ON PRODUCTION

    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    
    session_name("id");
    session_start();
    echo $_SESSION["userId"];
?>