<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Admin.php");


    if(isset($_POST["add_admin"])) {
        $post_valid1 = isset($_POST["lname"]) && isset($_POST["fname"]) && isset($_POST["email"]) && isset($_POST["contact"]);
        $post_valid2 = isset($_POST["pass"]) && isset($_POST["office"]) && isset($_POST["add_admin"]);
        if(!($post_valid1 && $post_valid2)) {
            header("Location: ../main/rtuappsys");
            die();
        }
    } else {
        // *********** Needs error message
        header("Location: ../main/rtuappsys");
        die();
    }

    $lname = $_POST["lname"];
    $fname = $_POST["fname"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $pass = $_POST["pass"];
    $office = $_POST["office"];

    // Insert Backend Validator

    session_name("cid");
    session_start();
    $oadmn_id = addAdminAccount($lname, $fname, $email, $contact, $pass, $office, $pass);
    
    if($oadmn_id) {
        if(addAdminAuth($oadmn_id, $pass)) {
            $_SESSION["add-admin-response"] = 200;
            $_SESSION["add-admin-id"] = $oadmn_id;
            header("Location: ../create-admin"); 
            
        }
    }
?>