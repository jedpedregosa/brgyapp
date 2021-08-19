<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    session_name("cid");
    session_start();

    if(isset($_SESSION["admin_uname"]) && isset($_SESSION["admin_chng"])) {
        header("Location: page/dashboard");
        die();
    }

    $isError = null;

    if(isset($_SESSION["admin_err"])) {
        $isError = $_SESSION["admin_err"];
        unset($_SESSION["admin_err"]);

        if($isError == 201) {
            $message = "Username or password is incorrect.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Login - RTU Appointment System</title>

	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_PROTOCOL . HOST . "/app/assets/css/admin-login.css" . FILE_VERSION; ?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/css/fnon.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
	<!-- HEADER -->
	<div class="headerBG">
		<img src="assets/img/header2.png">
	</div>
	  
	<div class="logoHeader">
		<img src="assets/img/rtu_logo.png">
	</div>
	<!-- //HEADER -->
	<!-- CONTENTS -->
	<div class="main">

		<!-- ROW -->
		<div class="row">

			<!-- COLUMN 1 -->
			<div class="col-1">

				<form action="controllers/authenticate" method="post">
	  			<div class="imgcontainer">
	    			<img src="assets/img/icon.png" alt="Avatar" class="avatar">
	  			</div>

	 				<p class="p1">Hi Administrator! <span><br>Manage RTU Appointment <br> Information!</span></p>

					  <div class="container">
					    <input type="text" placeholder=" Username" name="uname" required>
					    <p>
					      <input type="password" placeholder="Password" name="pword" id="password" />
					      	<span class="show">
					        <i class="bi bi-eye" id="togglePassword" onclick="toggle()"></i>
					      </span>
					    </p>
					   <br>
	        
	    			<button class="button" name = "sbmit_login" type="submit">LOGIN</button>

	  				</div>
				</form>
			</div>
			
			<!-- //COLUMN 1 -->
			<!--SCRIPT-->
			<script src="<?php echo HTTP_PROTOCOL . HOST . "/app/assets/js/admin-login.js" . FILE_VERSION; ?>"></script>
            <script src="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/js/fnon.min.js"></script>	
			<?php 
				if($isError) {
					echo "<script> Fnon.Alert.Warning({
								message: '". $message ."',
								title: 'Unfortunately,',
								btnOkText: 'Okay',
								titleBackground: '#002060',
								titleColor: 'White',
								fontFamily: 'Poppins, sans-serif'
							}); </script>";
				}
			?>
			<!--//SCRIPT-->

			<!-- COLUMN 2 -->
			<div class="col-2">
				<img src="assets/img/fg2.png" class="WorkBG">
				<div class="color-box"></div>
			</div>
			<!-- //COLUMN 2 -->

		</div>
		<!-- //ROW -->
	</div>

	<!-- DESIGN -->
	<div class="design">
		<img src="assets/img/design.png">
	</div>
	<!-- //DESIGN -->

	<!-- //CONTENTS -->
	<!-- FOOTER -->
	<div class="footer">
		<div class="footer-bottom">
			COPYRIGHT &copy; 2021 RIZAL TECHNOLOGICAL UNIVERSITY<!-- COPYRIGHT -->
		</div>
	</div>
	<!-- //FOOTER -->
</body>
</html>
