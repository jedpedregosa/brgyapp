<?php 

/////////////// SOURCE CODE TESTING PAGE 
/// DELETE test.php ON PRODUCTION

    $date = new DateTime("2021/7/11");
    $submtDate = $date->format('ymd');
    $office = str_replace("RTU-O", "", "RTU-O01");
    $id = 1;
    echo $submtDate . (string)$id;
?>