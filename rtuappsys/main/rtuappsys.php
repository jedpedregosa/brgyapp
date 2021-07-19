<html>
<body>
<?php

?>
<html lang = "en">
   <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../assets/css/loginstyle.css">
    <title>RTU Online Appointment System</title>

<!-- HEADER -->
  <div class="header">
    <img src="../assets/img/header2.png">
  </div>

  <div class="logoheader">
    <img src="../assets/img/rtu_logo.png">
  </div>

  <div class="frontgp">
    <img src="../assets/img/frontgp.png">
  </div>

  <div class="footer">
    <img src="../assets/img/footer2.png">
    <p>COPYRIGHT © 2021 RIZAL TECHNOLOGICAL UNIVERSITY</p>
  </div>
  
  <div class="div2">
    <img src="../assets/img/design.png">
  </div>


    <p class="p1"> RTU APPOINTMENT <br>
    SYSTEM </p>
    <p class="p2"> Welcome to Rizal Technological University! </p>
    


<div class="dropdown">
  <button onclick="myFunction()"class ="dropbtn">Make an Appointment</button>

  <div id ="myDropdown"class="dropdown-content">
  <button onclick="document.getElementById('id01').style.display='block'" class="text">As Student</button>
  <button onclick="document.getElementById('id02').style.display='block'" class="text">As Employee</button>
  <button onclick="document.getElementById('id03').style.display='block'" class="text">As Guest</button>
  </div>
</div>

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="../includes/chk-appointment.php?type=student" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="../assets/img/user.png" alt="Avatar" class="avatar">
    </div>

     <p class="p4"> Hi Student! </p>
     <p class="p5">Make an appointment today at RTU!</p>


        <div class="container">
        <label for="studno"><b></b></label>
        <input type="text" placeholder="Student Number" name="studentNum" required id="studentNum">
        <label for="ln"><b></b></label>
        <input type="text" placeholder="Last Name" name="sLname" required id="sLname">
    
        <input type = "submit" class="button1" value = "Proceed" id="submit-student">
 
    </div>
  </form>
</div>
      <div id="id02" class="modal">
        
        <form class="modal-content animate" action="../includes/chk-appointment.php?type=employee" method="post">
          <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="../assets/img/user.png" alt="Avatar" class="avatar">
          </div>
               <p class="p4"> Hi Employee! </p>
               <p class="p5">Make an appointment today at RTU!</p>

          <div class="container">
            <label for="empno"><b></b></label>
            <input type="text" placeholder="Employee Number" name="empNum" required id="empNum">

            <label for="ln"><b></b></label>
            <input type="text" placeholder="Last Name" name="eLname" required id="eLname">
            
            <input type = "submit" class="button1" value = "Proceed" id="submit-employee">
          </div>
     </form>
</div>

        <div id="id03" class="modal">
          
          <form class="modal-content animate" action="../includes/chk-appointment.php?type=guest" method="post">
            <div class="imgcontainer">
              <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
              <img src="../assets/img/user.png" alt="Avatar" class="avatar">
            </div>
                 <p class="p4"> Hi Guest! </p>
                    <p class="p5">Make an appointment today at RTU!</p>

            <div class="container">
              <label for="studno"><b></b></label>
              <input type="text" placeholder="Email" name="email" required id="email">

              <label for="ln"><b></b></label>
              <input type="text" placeholder="Last Name" name="gLname" required id="gLname">
                
              <input type = "submit" class="button1" value = "Proceed" id="submit-guest">
         
            </div>
          </form>
        </div>

       
          <div class="dropbtn1">
              <div class ="button2" onclick="document.getElementById('id04').style.display='block'" style="width:auto;">View Appointment</div>
              <div id="id04" class="modal">
  
              <form class="modal-content animate" action="/action_page.php" method="post">
            <div class="imgcontainer">
              <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
              <img src="../assets/img/user.png" alt="Avatar" class="avatar">
            </div>

                 <p class="p5">VIEW MY APPOINTMENT</p>


                    <div class="container">
                    <label for="email"><b></b></label>
                    <input type="text" placeholder="Email Address" name="email" required>
                    <label for="ln"><b></b></label>
                    <input type="text" placeholder="Last Name" name="*" required>
                
                    <div class="button1">Proceed</button>
          </form>
        </div>  
    </div>
  </div>
</div>
</form>
</div>
 
	<a href="#">
    <p class="p3">Submit Feedback here!</p>
  </a>

  <script>

    // Validation

    // Unique ID's 
    const studentNum = document.getElementById('studentNum');
    const empNum = document.getElementById('empNum');
    const email = document.getElementById('email');

    // User's Lastname
    const sLname = document.getElementById('sLname');
    const eLname = document.getElementById('eLname');
    const gLname = document.getElementById('gLname');

    // Submit
    const submitStudent = document.getElementById('submit-student');
    const submitEmployee = document.getElementById('submit-employee');
    const submitGuest = document.getElementById('submit-guest');

    // Regex for validation
    var lastnameRegex = /^[a-zA-Z]*$/;
    var studentRegex = /^[0-9]+-[0-9]*$/;
    var employeeRegex = /^[A-Z]+-[0-9]+-[0-9]+-[0-9]+-[0-9]*$/;
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        
    submitStudent.addEventListener('click',()=>{
    // Student Modal Validation

    // Student Number Validation
    if(studentNum.value == null || studentNum.value == ''){
      studentNum.setCustomValidity('Please fill out this field');
    }else if (!studentNum.value.match(studentRegex) || studentNum.value.length != 11){
      studentNum.setCustomValidity('Invalid Student Number');
    } else {
      studentNum.setCustomValidity('');
    }

    // Student Last Name Validation
    if(sLname.value == null || sLname.value == ''){
      sLname.setCustomValidity('Please fill out this field');
    }else if (!sLname.value.match(lastnameRegex) || sLname.value.length < 2){
      sLname.setCustomValidity('Invalid Last Name');
    } else {
      sLname.setCustomValidity('');
    }

    });

    submitEmployee.addEventListener('click',()=>{
    // Employee Modal Validation

    // Employee Number Validation
    if(empNum.value == null || empNum.value == ''){
      empNum.setCustomValidity('Please fill out this field');
    }else if (!empNum.value.match(employeeRegex) || empNum.value.length != 11){
      empNum.setCustomValidity('Invalid Employee Number');
    } else {
      empNum.setCustomValidity('');
    }

    // Employee Last Name Validation
    if(eLname.value == null || eLname.value == ''){
      eLname.setCustomValidity('Please fill out this field');
    }else if (!eLname.value.match(lastnameRegex) || eLname.value.length < 2){
      eLname.setCustomValidity('Invalid Last Name');
    } else {
      eLname.setCustomValidity('');
    }

    });

    submitGuest.addEventListener('click',()=>{
    // Guest Modal Validation

    // Guest Number Validation
    if(email.value == null || email.value == ''){
      email.setCustomValidity('Please fill out this field');
    }else if (!email.value.match(emailRegex)){
      email.setCustomValidity('Invalid Email Address');
    } else {
      email.setCustomValidity('');
    }

    // Guest Last Name Validation
    if(gLname.value == null || gLname.value == ''){
      gLname.setCustomValidity('Please fill out this field');
    }else if (!gLname.value.match(lastnameRegex) || gLname.value.length < 2){
      gLname.setCustomValidity('Invalid Last Name');
    } else {
      gLname.setCustomValidity('');
    }
    });
  </script>

</body>
</html>
