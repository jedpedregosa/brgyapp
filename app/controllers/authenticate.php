<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Admin.php");

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

    if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"])) {
        header("Location: ../page/dashboard");
        die();
    }

    if(userIsAuthenticated($username, $password)) {
        $_SESSION["admin_uname"] = $username;
        $_SESSION["admin_chng"] = getLastPasswordChange($username);

        header("Location: ../page/dashboard");
    } else {
        $_SESSION["admin_err"] = 201;
        header("Location: ../login");
    }
?>