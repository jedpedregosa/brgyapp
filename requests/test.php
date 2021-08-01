<?php
    $path = $_SERVER['REQUEST_URI'];
    $paths = explode('/', path);
    $lastIndex = count($paths) - 1;
    $fileName = $paths[$lastIndex]; // Maybe add some code to detect subfolder if you have them
    // Check if that file exists, if no show some error message
    // Output headers here
    echo $fileName;
?>