<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Admin.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/SystemLog.php");

    if(isset($_POST["sbmit_login"])) {
        if(!(isset($_POST["uname"]) && isset($_POST["pword"]))) {
            header("Location: ../login");
            die();
        }
    } else {
        header("Location: ../login");
        die();
    }

    $username = $_POST["uname"];
    $password = $_POST["pword"];

    session_name("cid");
    session_start();

    if(sys_in_maintenance) {
        $_SESSION["admin_err"] = 505;
        header("Location: " . HTTP_PROTOCOL . $_SERVER['HTTP_HOST'] . "/app");
        die();
    }

    if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"])) {
        header("Location: ../page/dashboard");
        die();
    }

    if(!doesAdminExist($username)) {
        createLog("A user", "3", USER_IP);
        goBack();
    }

    if(isAdminBlocked($username)) {
        goBack(201);
    }

    if(userIsAuthenticated($username, $password)) {
        session_regenerate_id();
        
        $_SESSION["admin_uname"] = $username;
        $_SESSION["admin_chng"] = getLastPasswordChange($username);
        $_SESSION["admin_session_expiry"] = time() + 60 * (int)oadmin_min_session_expr;

        deleteAllAdminAttempt($username);

        createLog($username, "4", USER_IP);

        header("Location: ../page/dashboard");
    } else {
        createLog($username, "3", USER_IP);

        addAdminAttempt($username);
        goBack();
    }

    function goBack($errorCode = 202) {
        $_SESSION["admin_err"] = $errorCode;
        header("Location: ../login");
        die();
    }
?>