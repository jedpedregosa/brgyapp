<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/AdminConfig.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/SystemLog.php");

    if(isset($_POST["adm_sbmt"])) {
        if(!(isset($_POST["adm_uname"]) && isset($_POST["adm_pass"]))) {
            header("Location: ../login");
            die();
        }
    } else {
        header("Location: ../login");
        die();
    }

    $username = $_POST["adm_uname"];
    $password = $_POST["adm_pass"];

    session_name("cid");
    session_start();

    if(isset($_SESSION["config_admin_uname"]) && isset($_SESSION["config_admin_chng"])) {
        header("Location: ../page/main");
        die();
    }

    if(!doesConfigAdminExist($username)) 
    {
        createLog("A user", "5", USER_IP);
        goBack();
    } 

    if(isBlocked($username)) {
        goBack(201);
    }

    if(configIsAuthenticated($username, $password)) {
        $_SESSION["config_admin_uname"] = $username;
        $_SESSION["config_admin_chng"] = configLastPasswordChange($username);
        $_SESSION["config_session_expiry"] = time() + 60 * (int)config_min_session_expr;

        createLog($username, "6", USER_IP);
        deleteAllAttempt($username);

        header("Location: ../page/main");
    } else {
        createLog($username, "5", USER_IP);

        addConfigAttempt($username);
        goBack();
    }

    function goBack($errorCode = 202) {
        $_SESSION["config_admin_err"] = $errorCode;
        header("Location: ../login");
        die();
    }
?>