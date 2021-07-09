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
  <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">As Student</button>
  <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">As Employee</button>
  <button onclick="document.getElementById('id03').style.display='block'" style="width:auto;">As Guest</button>
  </div>
</div>

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="create/appointment.php?type=student" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="../assets/img/user.png" alt="Avatar" class="avatar">
    </div>

     <p class="p4"> Hi Student! </p>
     <p class="p5">Make an appointment today at RTU!</p>


        <div class="container">
        <label for="studno"><b></b></label>
        <input type="text" placeholder="Student Number" name="studentNum" required>
        <label for="ln"><b></b></label>
        <input type="text" placeholder="Last Name" name="sLname" required>
    
        <input type = "submit" class="button1" value = "Proceed">
 
    </div>
  </form>
</div>
      <div id="id02" class="modal">
        
        <form class="modal-content animate" action="create/appointment.php?type=employee" method="post">
          <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="../assets/img/user.png" alt="Avatar" class="avatar">
          </div>
               <p class="p4"> Hi Employee! </p>
               <p class="p5">Make an appointment today at RTU!</p>

          <div class="container">
            <label for="empno"><b></b></label>
            <input type="text" placeholder="Employee Number" name="empNum" required>

            <label for="ln"><b></b></label>
            <input type="text" placeholder="Last Name" name="eLname" required>
            
            <input type = "submit" class="button1" value = "Proceed">
          </div>
     </form>
</div>

        <div id="id03" class="modal">
          
          <form class="modal-content animate" action="create/appointment.php?type=guest" method="post">
            <div class="imgcontainer">
              <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
              <img src="../assets/img/user.png" alt="Avatar" class="avatar">
            </div>
                 <p class="p4"> Hi Guest! </p>
                    <p class="p5">Make an appointment today at RTU!</p>

            <div class="container">
              <label for="studno"><b></b></label>
              <input type="text" placeholder="Email" name="email" required>

              <label for="ln"><b></b></label>
              <input type="text" placeholder="Last Name" name="gLname" required>
                
              <input type = "submit" class="button1" value = "Proceed">
         
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
                    <input type="text" placeholder="Last Name" name="email" required>
                
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


</body>
</html>