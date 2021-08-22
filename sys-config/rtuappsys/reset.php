<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/AdminConfig.php");

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
        header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/sys-config");
    }
?>