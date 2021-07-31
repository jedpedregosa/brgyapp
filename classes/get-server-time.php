<?php
    date_default_timezone_set("Asia/Manila");
    $currentDateTime = new DateTime();
    $dateTime = $currentDateTime->format("D, d M Y H:i:s \G\M\T");

    echo $dateTime;
?>