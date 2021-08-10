<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Feedback.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");

    session_name("cid");
    session_start();

    $fname = null;
    $cat = null; 
    $email = null;
    $contact = null;
    $office = null;
    $feedback = null;
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST["sbmt_feedback"])) {
            $val1 = isset($_POST["fullname"]) && isset($_POST["category"]) && isset($_POST["email"]) && isset($_POST["contact"]);
            if($val1 && isset($_POST["office"]) && !empty($_POST["feedback"])) {
                $fname = $_POST["fullname"];
                $cat = $_POST["category"];
                $email = $_POST["email"];
                $contact = $_POST["contact"];
                $office = $_POST["office"];
                $feedback = $_POST["feedback"];
                $isSatisfied = ($_POST["isSatisfied"] ? 1 : 0);
            } else {
                goBack();
            }
        } else {
            goBack();
        }
    } else {
        goBack();
    }
    
    if(!doesOfficeExist($office)) {
        goBack();
    }

    $ip = (isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDE‌​D_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR']);

    $response = saveFeedback($fname, $cat, $contact, $office, $email, $feedback, $isSatisfied, $ip);

    if($response) {
        $_SESSION["error_status"] = 300;
        header("Location: ../main/rtuappsys");
    } else {
        goBack();
    }

    function goBack($error_code = 301) {
        $_SESSION["error_status"] = $error_code;
        header("Location: ../main/feedback");
        die();
    }
?>