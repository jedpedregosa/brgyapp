<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		feedback.php (Web Page) -- 
 *  Description:
 * 		1. Allows users (specifically visitors) to create a feedback.
 * 
 * 	Date Created: 14th of August, 2021
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

	include_once($_SERVER['DOCUMENT_ROOT'] . "/main/master.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Office.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");

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

	<title>Write a Feedback - RTU Appointment System</title>

	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_PROTOCOL . HOST . "/assets/css/FeedbackStyle.css" . FILE_VERSION; ?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
 	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/css/fnon.min.css" />
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
	<main>
		<!-- RTU BG IMAGE -->
		<div class="column">
			<img src="../assets/img/rtu_bg.png">
		</div>
		<!-- //RTU BG IMAGE -->

		<!--FORM DIV -->
		<div class="column">
			<!-- FORM -->
			<form id="formFeedback" action="../requests/sub-feedback" method = "POST">
				<!-- FORM HEADER DESCRIPTION -->
				<div class="desc">
					<p class="header1">Give your feedback here!</p>
				</div>
				<!-- //FORM HEADER DESCRIPTION -->

				<!-- LINE 1 -->
				<div class="row">
					<div class="columns left">
						<!-- USER CATEGORY -->
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
			    		<!-- //USER CATEGORY -->
					</div>

					<div class="columns right">
						<!-- USER FULLNAME INPUT -->
					    <input type="text" id="fullname" name="fullname" placeholder="Last Name, First Name" required autocomplete="off">
					    <!-- //USER FULLNAME INPUT -->
					</div>
				</div>
				<!-- //LINE 1 -->

				<!-- LINE 2 -->
				<div class="row">
					<div class="columns left">
						<!-- USER EMAIL INPUT -->
					    <input type="email" id="emailAdd" name="email" placeholder="Email Address" required autocomplete="off">
					    <!-- //USER EMAIL INPUT -->
					</div>

					<div class="columns right">
						<!-- USER CONTACT NO. INPUT -->
					    <input type="tel" id="contactNo" name="contact" placeholder="Contact Number" pattern="[0-9]{11}" required autocomplete="off">
					    <!-- //USER CONTACT NO. INPUT -->
					</div>
					
				</div>
				<!-- //LINE 2 -->

				<!-- LINE 3 -->
				<div class="row">
					<div class="office_names">
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
					</div>
				</div>
				<!-- //LINE 3 -->

				<!-- LINE 4 -->
				<div class="row">
					<!-- TEXTAREA FEEDBACK -->
					<div class="textarea">
				    	<textarea placeholder="Write your feedback here..." name ="feedback" required></textarea>
				    </div>
				    <!-- //TEXTAREA FEEDBACK -->
				</div>
				<!-- //LINE 4 -->

				<div class="row">
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
				</div> 
			</form>
			<!-- //FORM -->
		</div>
		<!--FORM DIV -->
	</main>
	<!-- //CONTENTS -->

	<!-- FOOTER -->
	<div class="footer">
		<div class="footer-bottom">
		COPYRIGHT &copy; 2021 RIZAL TECHNOLOGICAL UNIVERSITY<!-- COPYRIGHT -->
		</div>
	</div>
	<!-- //FOOTER -->

	<!-- JAVASCRIPT USED -->
	<script src="<?php echo HTTP_PROTOCOL . HOST . "/assets/js/FeedbackScript.js" . FILE_VERSION; ?>"></script>
    <script src="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/js/fnon.min.js"></script>
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
