<?php 
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");
	
	session_name("cid");
	session_start();

	$all_office = loadAllOffice();

	$alert = false;
	$title;
	$message;

	if(isset($_SESSION["error_status"])) {
		$error_code = $_SESSION["error_status"];

		if($error_code == 301) {
			$alert = true;
			$title = "Oops,";
			$message = "There seem to be a problem when submitting feedbacks, please try again later.";
		}
		unset($_SESSION["error_status"]);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Appointment Feedback</title>

	<link rel="stylesheet" href="../assets/css/FeedbackStyle.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
 	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	 <link rel="stylesheet" href="../assets/css/fnon.min.css" />

</head>
<body>
	<!-- HEADER -->
	<div class="headerBG">
		<img src="../assets/img/header2.png">
	</div>
	  
	<div class="logoHeader">
		<img src="../assets/img/rtu_logo.png">
	</div>
	<!-- //HEADER -->

	<!-- CONTENTS -->
	<div class="main">
		<!-- RTU BG IMAGE -->
		<div class="column">
			<img src="../assets/img/rtu_bg.png">
		</div>
		<!-- //RTU BG IMAGE -->

		<!--FORM DIV -->
		<div class="column">
			<div class="form">

				<!-- FORM ACTION -->
				<form action="../requests/sub-feedback" method = "post" id="formfeed">

					<!-- FORM HEADER DESCRIPTION -->
					<div class="desc">
						<p class="header1">Give your feedback here!</p>
						<p class="header2">Kindly write your feedback below in visiting RTU for better service.</p>
					</div>
					<!-- //FORM HEADER DESCRIPTION -->

					<div class="appt">
						<!-- FULLNAME INPUT -->
                        <input type="text" id="fullname" name="fullname" placeholder="Last Name, First Name" required>
				    		<!-- //FULLNAME INPUT -->
			    	</div>

			    	<!-- LINE 1 -->
			    	<div class="row1">
				    	<div class="column left1"><!-- LINE 1 LEFT COL -->
                            <!-- CATEGORY (Student, Employee or Guest) -->
						    <div class="container">
							    <div class="select-box">
							    	<div class="options-container">
							    		<div class="option">
							    			<input type="radio" class="radio" id="student" name="category" value = "student">
							    			<label for="student">Student</label>
							    		</div>

							    		<div class="option">
							    			<input type="radio" class="radio" id="employee" name="category" value = "employee">
							    			<label for="employee">Employee</label>
							    		</div>

							    		<div class="option">
							    			<input type="radio" class="radio" id="guest" name="category" value = "guest">
							    			<label for="guest">Guest</label>
							    		</div>
							    	</div>

							    	<div class="selected">
							    			Write your feedback as...
							    	</div>
							    </div>
							</div>
							<!-- //CATEGORY (Student, Employee or Guest) -->
				    	</div><!-- //LINE 1 LEFT COL -->

				    	<div class="column right1"><!-- LINE 1 RIGHT COL -->
                            <input type="text" name="email" placeholder="Your Email" required>
				    	</div><!-- //LINE 1 RIGHT COL -->
				    </div>
				    <!-- //LINE 1 -->

				    <!-- LINE 2 -->
				    <div class="row1">
				    	<div class="column left2"><!-- LINE 2 LEFT COL -->

				    		<!-- OFFICE NAMES -->
				    		<div class="container2">
						    	<div class="select-box2">
						    		<div class="options-container2">
								<?php 
									$i = 0;
									foreach((array)$all_office as $office) {
										$display = $office["office_name"] . ", " . $office["office_branch"];
										?>
											<div class="option2">
						    					<input type="radio" class="radio2" id="<?php echo $i; ?>" name="office" value = "<?php echo htmlspecialchars($office["office_id"])?>">
						   						<label for="<?php echo $i; ?>"><?php echo htmlspecialchars($display); ?></label>
						   					</div>
										<?php
										$i++;
									}
								
								?>						    			
					    			</div>
						  
						   			<div class="selected2">
						    			Office Name
						    		</div>
						    	</div>
						   	</div>
						   	<!-- //OFFICE NAMES -->

						</div><!-- //LINE 2 LEFT COL -->

						<div class="column right2"><!-- LINE 2 RIGHT COL -->
                            <input type="text" id="contact" name="contact" placeholder="Your Contact Number" required>
				    	</div>
				    	<!-- //LINE 2 RIGHT COL -->

				    </div>
				    <!-- //LINE 2 -->
                        <!-- TEXTAREA FEEDBACK -->
                            <div class="textarea">
                                <textarea placeholder="State your feedback here..." name ="feedback" required></textarea>
                            </div>
                        <!-- //TEXTAREA FEEDBACK -->

				    <div class="feedback_buttons">
					    <!-- LIKE & DISLIKE BUTTON -->
					    <div class="rating_wrapper">
					    	<!-- LIKE -->
					    	<div class="like" id="like" onclick="likes()">
					    		<i class="bi bi-heart-fill" id="likeIcon"></i>
					    		<span class="like_dislike">Satisfied</span>
					    	</div>
					    	<!-- //LIKE -->

					    	<!-- DISLIKE -->
					 		<div class="dislike" id="dislike" onclick="dislikes()">
					 			<i class="bi bi-heart-half" id="dislikeIcon"></i>
					    		<span class="like_dislike">Unsatisfied</span>
					 		</div>
					 		<!-- //DISLIKE -->
					    </div>
					    <!-- //LIKE & DISLIKE BUTTON -->
						<div style = "display:none">
							<input type = "text" name = "isSatisfied" id = "isSatisfied">
						</div>
					    <!-- SUBMIT BUTTON -->
					    <div class="submit">
					    	<input type="submit" value="Submit Feedback" id="Submit" name = "sbmt_feedback">
					    </div>
					    <!-- //SUBMIT BUTTON -->
				   </div>

				</form>
				<!-- //FORM ACTION -->

			</div>	
		</div>
		<!-- //FORM DIV -->

	</div>
	<!-- //CONTENTS -->

	<!-- FOOTER -->
	<div class="footer">
		<div class="footer-bottom">
		COPYRIGHT &copy; 2021 RIZAL TECHNOLOGICAL UNIVERSITY<!-- COPYRIGHT -->
		</div>
	</div>
	<!-- //FOOTER -->

	<!-- JAVASCRIPT USED -->
	<script src="../assets/js/FeedbackScript.js"></script>
	<script src="../assets/js/fnon.min.js"></script>
	<?php 
		if($alert) {
			echo "<script> Fnon.Alert.Danger({
					message: '". $message ."',
					title: '" . $title . "',
					btnOkText: 'Okay',
					fontFamily: 'Poppins, sans-serif'
				}); </script>";
			}
	?>	
	<!-- //JAVASCRIPT USED -->
</body>
</html>