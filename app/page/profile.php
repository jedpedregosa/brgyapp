<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

    $admin_data = getAdminData($admin_id);

	$message;
    $title;
	$errorCode;

    if(isset($_SESSION["upd_alert"])) {
		$errorCode = $_SESSION["upd_alert"];	
		if($errorCode == 300) {
			$title = "Update Profile";
			$message = "Profile update executed successfully.";
		} else if($errorCode == 303) {
			$title = "Change Password";
			$message = "Your old password does not match.";
		}
		else if($errorCode > 300) {
			$title = "Appointment";
            $message = "Oops, something went wrong. Please try again.";
		}
		unset($_SESSION["upd_alert"]);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo htmlspecialchars($full_name); ?> | RTU Appointment System</title>

	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_PROTOCOL . HOST . "/assets/css/OA-ProfileStyle.css" . FILE_VERSION ?>">
	<link rel="stylesheet" href="../../assets/css/fnon.min.css" />
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>

	<!-- Side Navigation Bar -->
	<div class="sidebar">

		<!-- User Image Container -->
		<div class="user-con">

			<!-- User Image Container -->
			<div class="user-img">
				<!-- User Image -->
				<div class="bar-user-img">
					<img src="view/load_image" id="bar-pic" alt="Not Found" onerror="this.src='../assets/img/user-ico'">
				</div>
				<!-- //User Image -->
			</div>
			<!-- //User Image Container -->

			<!-- User Name, Title and Line -->
			<div class="name"><?php echo htmlspecialchars($full_name); ?></div>
			<div class="job">Office Administrator</div>
			<div class="line"></div>
			<!-- //User Name, Title and Line -->

		</div>
		<!-- //User Image Container -->

		<!-- Navigation List -->
		<ul class="nav-list">
			<li>
				<i class="bi bi-search"></i>
				<input type="text" placeholder="Search...">
				<span class="tooltip">Search</span>
			</li>
			<li>
				<a href="dashboard">
					<i class="bi bi-columns-gap"></i>
					<span class="links_name">DASHBOARD</span>
				</a>
				<span class="tooltip">Dashboard</span>
			</li>
			<li>
				<a href="view/appointment">
					<i class="bi bi-calendar3"></i>
					<span class="links_name">APPOINTMENTS</span>
				</a>
				<span class="tooltip">Appointments</span>
			</li>
			<li>
				<a href="view/feedback">
					<i class="bi bi-star"></i>
					<span class="links_name">FEEDBACK</span>
				</a>
				<span class="tooltip">Feedback</span>
			</li>
			<li>
				<a href="javascript:window.location.reload(true)" class="active">
					<i class="bx bx-user"></i>
					<span class="links_name">PROFILE</span>
				</a>
				<span class="tooltip">Profile</span>
			</li>
			<div class="line2"></div>

			<a href = "logout">
                <li class="logout">
                    <i class='bi bi-box-arrow-right' id="log_out"></i>
                    <span class="logout-label">Logout</span>
                </li>
            </a>
		</ul>
		<!-- //Navigation List -->

	</div>
	<!-- //Side Navigation Bar -->

	<!-- Header -->
	<section class="header-section">
		<div class="header-border">
			<div class="header">
				<div class="sys-title">
					<img src="../assets/img/menu.png" id="btn">
					RTU APPOINTMENT SYSTEM <!-- Add here the office name -->
				</div>

				<div class="user-wrapper">
					<!-- User Image Container -->
					<div class="header-user-con">

						<!-- User Image -->
						<div class="header-user-img">
							<img src="view/load_image" id="header-pic" alt="Not Found" onerror="this.src='../assets/img/user-icon.png'">
						</div>
						<!-- //User Image -->
					</div>
					<!-- //User Image Container -->

					<div class="user-name">
						<a href="javascript:window.location.reload(true)"><h5><?php echo htmlspecialchars($full_name); ?></h5></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- //Header -->

	<!-- Contents -->
	<main>
		<!-- Contents Container -->
		<div class="contents">

			<!-- Page Title -->
			<div class="page-title">
				PROFILE
			</div>
			<!-- //Page Title -->

			<!-- User Image Container -->
			<div class="profile-user-con">

				<!-- User Image -->
                <form action = "../controllers/upload" method = "post" id = "form_upload" name="upload" enctype="multipart/form-data">
                    <div class="profile-user-img">
                        <img src="view/load_image" id="profile-photo" alt="Not Found" onerror="this.src='../assets/img/user-icon.png'">
                        <input type="file" name="image" id="file" accept="image/*" required>
                        <label for="file" id="uploadBtn">Upload Photo</label>
                    </div>
                </form>
				<!-- //User Image -->

			</div>
			<!-- //User Image Container -->

			<!-- Page Header -->
			<div class="page-header">
				<h4>Account Information</h4>
			</div>
			<!-- //Page Header -->

			<!-- User Profile Info Form -->
			<form class="user-infos" action = "../controllers/upd_profile" method = "POST">
				<div class="user-info">
					<div class="first column">
						<div class="info-fields">
							<label>Username</label>
							<input type="text" id="username" placeholder="Username" value = "<?php echo htmlspecialchars($admin_data[0]); ?>" disabled>
						</div>

						<div class="info-fields">
							<label>First Name</label>
							<input type="text" name="first-name" id="first-name" placeholder="First Name" value = "<?php echo htmlspecialchars($admin_data[2]); ?>" required>
						</div>

						<div class="info-fields">
							<label>Last Name</label>
							<input type="text" name="last-name" id="last-name" placeholder="Last Name" value = "<?php echo htmlspecialchars($admin_data[1]); ?>" required>
						</div>
					</div>

					<div class="second column">
						<div class="info-fields">
							<label for="email-address">Email Address</label>
							<input type="email" name="email-address" id="email-address" placeholder="sample@gmail.com" value = "<?php echo htmlspecialchars($admin_data[3]); ?>" required>
						</div>

						<div class="info-fields">
							<label>Password</label>

							<button type="button" class="edit-pass" onclick="document.getElementById('id01').style.display='block'">
								<i class="bi bi-pencil-square" title="Change Password"></i>
								<span>Change Password</span>
							</button>
						</div>

						<div class="info-fields">
							<label for="phone-number">Phone Number</label>
							<input type="tel" name="phone-number" id="phone-number" placeholder="xxxx-xxx-xxxx" pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}" value = "<?php echo htmlspecialchars($admin_data[4]); ?>" required>
						</div>
					</div>
				</div>

				<div class="info-button">
					<input type="submit" class = "uptd_button" name = "upd_sbmt" value="Update Profile">
				</div>
			</form>
			<!-- //User Profile Info Form -->
		</div>
		<!-- //Contents Container -->

		<!-- Create New Password Modal -->
		<div id="id01" class="modal">

			<!-- Form -->
		<form class="modal-content animate" action="../controllers/chng-pass" method="POST">

				<!-- Close Button Container -->
				<div class="closeContainer">
      		<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    		</div>
    		<!-- Close Button Container -->

    		<!-- Form Container -->
    		<div class="container">
    			<h2>Create new password</h2>

    			<!-- Error Message if Current Password is wrong -->
    			<div id="error"></div>
    			<!-- //Error Message if Current Password is wrong -->

    			<!-- Current Password -->
    			<div class="passCon">
    				<label for="currentPassword"><b>Current Password</b></label>
	      		<input type="password" placeholder="Enter Current Password" name="currentPassword" id="currentPassword" autocomplete="off" required>
	      		
	      		<!-- Show Password -->
	      		<span class="show">
		      		<i class="bi bi-eye" id="eye1" onclick="toggle1()"></i>  
	  	  		</span>
	  	  		<!-- //Show Password -->
    			</div>
    			<!-- //Current Password -->

    			<!-- New Password -->
    			<div class="passCon">
    				<label for="newPassword"><b>New Password</b></label>
	      		<input type="password" placeholder="Enter New Password" name="newPassword" id="newPassword" autocomplete="off" onkeyup="password()" required>

	      		<!-- Show Password -->
	      		<span class="show">
	      			<i class="bi bi-eye" id="eye2" onclick="toggle2()"></i>
	      		</span>
	      		<!-- //Show Password -->

	      		<!-- New Password Strength Checker -->
	      		<div id="mess">
			      	<span id="upper">
			      		<i class="bi bi-check-lg"></i>
			      		Uppercase letter
			      	</span><br>

			      	<span id="lower">
			      		<i class="bi bi-check-lg"></i>
			      		Lowercase letter
			      	</span><br>

			      	<span id="digit">
			      		<i class="bi bi-check-lg"></i>
			      		At least 1 number
			      	</span><br>

			      	<span id="special">
			      		<i class="bi bi-check-lg"></i>
			      		At least 1 special character
			      	</span><br>

			      	<span id="len">
			      		<i class="bi bi-check-lg"></i>
			      		At least 8 characters long
			      	</span>
      			</div>
      			<!-- //New Password Strength Checker -->
    			</div>
    			<!-- //New Password -->

    			<!-- Confirm New Password -->
    			<div class="passCon">
    				<label for="cNewPassword"><b>Confirm New Password</b></label>
      			<input type="password" placeholder="Re-enter new password" name="cNewPassword" id="cNewPassword" autocomplete="off" onkeyup="valid()" required>

      			<!-- Show Password -->
      			<span class="show">
      				<i class="bi bi-eye" id="eye3" onclick="toggle3()"></i>  
      			</span>
      			<!-- //Show Password -->

      			<!-- Alert Message if password match and filled out -->
      			<div id="alertMessage"></div>
      			<!-- //Alert Message if password match and filled out -->
    			</div>
    			<!-- //Confirm New Password -->

    			<!-- Cancel and Update Password Buttons -->
    			<div class="buttons">
    				<button type="reset" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      				<button type="submit" name = "upd_pass">Update Password</button>
    			</div>
    			<!-- //Cancel and Update Password Buttons -->
    		</div>
    		<!-- //Form Container -->
			</form>
			<!-- //Form -->
		</div>
		<!-- //Create New Password Modal -->
	</main>
	<!-- //Contents -->

	<!-- Javascript -->
	<script src="../assets/js/OA-ProfileScript.js"></script>
	<script src="../../assets/js/fnon.min.js"></script>
	<?php 
		if($errorCode == 300) {
			echo "<script> Fnon.Alert.Warning({
				message: '". $message ."',
				title: '" . $title . "',
				btnOkText: 'Okay',
				btnOkColor: 'White',
            	btnOkBackground: '#002060',
				fontFamily: 'Poppins, sans-serif'
			}); </script>";
		} else if($errorCode > 300){
			echo "<script> Fnon.Alert.Danger({
				message: '". $message ."',
				title: '" . $title . "',
				btnOkText: 'Okay',
				fontFamily: 'Poppins, sans-serif'
			}); </script>";
		}
	?>
	<!-- //Javascript -->

</body>
</html>
