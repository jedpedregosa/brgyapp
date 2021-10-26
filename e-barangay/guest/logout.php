<?php 

    session_name("b_cid");
    session_start();
    
    if(isset($_SESSION["resdnt_sess_loggedin"])) {
        $is_valid = isset($_SESSION["resdnt_sess_uname"])
            && isset($_SESSION["resdnt_sess_tmeout"])
            && isset($_SESSION["resdnt_sess_pwrdchng"]);
        
        if($is_valid) {
            unset($_SESSION["resdnt_sess_loggedin"]);
            unset($_SESSION["resdnt_sess_uname"]);
            unset($_SESSION["resdnt_sess_tmeout"]);
            unset($_SESSION["resdnt_sess_pwrdchng"]);
        }
    }

    header("Location: login");
?>