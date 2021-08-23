<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		sys-config/login.php (Access Page) -- 
 *  Description:
 * 		1. Login interface for system administrators.
 * 
 * 	Date Created: 20th of August, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	
 *  Lacks: 
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 ******************************************************************************/

    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/AdminConfig.php");

    session_name("cid");
    session_start();

    if(isset($_SESSION["config_admin_uname"]) && isset($_SESSION["config_admin_chng"])) {
        header("Location: page/main");
        die();
    }

    $isError = false;
    if(isset($_SESSION["config_admin_err"])) {
        $isError = true;
        $err = $_SESSION["config_admin_err"];

        if($err == 201) {
            $error_id = "err-1";
        } else {
            $error_id = "err-2";
        }

        unset($_SESSION["config_admin_err"]);
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Login - System Configuration</title>

	<link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/css/SA-Login.css" . FILE_VERSION; ?>">
	 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

</head>
<body>
    <form action="controllers/check-admin" method="post">
	 				<p class="greeting">Welcome!</p>

	 				<div class="imgcontainer">
	    			<img src="assets/img/SA.png" alt="Avatar" class="avatar">

					  <div class="container">
					    <input type="text" placeholder=" Username" name="adm_uname" autocomplete="off" required>
				        <input type="password" placeholder=" Password" name="adm_pass" id="password" autocomplete="off" required />
					      	<span class="show">
					        <i class="bi bi-eye" id="togglePassword" onclick="toggle()"></i>
					      </span>
					    </p>
                        <div id = "err-1" class = "error_msg">
                            <span>Reached the maximum login per hour.</span>
                        </div>
                        <div id = "err-2" class = "error_msg">
                            <span>Username or password is incorrect.</span>
                        </div>
	        
	    			<input class="button" type="submit" name = "adm_sbmt" value = "Login">

	  			</div>
			</form>
		</div>
		
			<script src="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/js/SA-Login.js" . FILE_VERSION; ?>"></script>
            <?php 
                if($isError) {
                    ?>
                        <script> document.getElementById("<?php echo $error_id; ?>").style.display = 'block'; </script>
                    <?php
                }
            ?>

		<div class="footer">
		<div class="footer-bottom">
		COPYRIGHT &copy; 2021 RIZAL TECHNOLOGICAL UNIVERSITY<!-- COPYRIGHT -->
		</div>
	</div>
	<!-- //FOOTER -->
</body>

</html>

