<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");

    $firstname = null;
    $lastname = null;
    $email = null;
    $phone = null;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!isset($_POST["upd_sbmt"])) {
            goBack();
        }
        if(isset($_POST["first-name"]) && isset($_POST["last-name"]) && isset($_POST["email-address"]) && isset($_POST["phone-number"])) {
            $firstname = $_POST["first-name"];
            $lastname = $_POST["last-name"];
            $email = $_POST["email-address"];
            $phone = $_POST["phone-number"];
        } else {
            goBack();
        }
    } else {
        goBack();
    }

    $result = updateData($admin_id, $firstname, $lastname, $email, $phone);

    if($result) {
        goBack(300);
    } else {
        goBack();
    }

    function goBack($error_code = 301) {
        $_SESSION["upd_alert"] = $error_code;
        header("Location: ../page/profile");
        die();
    }
?>