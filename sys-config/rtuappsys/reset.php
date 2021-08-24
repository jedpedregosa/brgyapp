<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/AdminConfig.php");
    
    session_name("cid");
    session_start();

    $config_admin_detail = [
        [
            "eRTUmic_2021",
            "RTUsys_4pp"
        ],
        [
            "m1c2021_eRTU",
            "rtu5y5_aPp",
        ],
        [
            "3RTU2021_mic",
            "sys4pp_RTU"
        ]
    ];

    if(configSysReset($config_admin_detail)) {
        $_SESSION["config_admin_reset"] = 100;
    } else {
        $_SESSION["config_admin_reset"] = 101;
    }

    header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/sys-config");
?>