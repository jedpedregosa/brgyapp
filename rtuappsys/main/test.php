<?php 

/////////////// SOURCE CODE TESTING PAGE 
/// DELETE test.php ON PRODUCTION

    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    print(getUserData('2018-103147', 'student')[0]);
?>