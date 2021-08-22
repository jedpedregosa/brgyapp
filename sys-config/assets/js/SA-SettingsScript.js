// RTU APPOINTMENT SYSTEM - ADMINISTRATOR

// JS for Side Navigation Bar
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".qr");

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)
});

searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search icon
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});


// Displaying arrow when typing
let arrow = document.querySelector("#arrow");

function Typing() {
  arrow.style.display = "block";
  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search icon
    arrow.style.display = "none";
  });

  closeBtn.addEventListener("click", ()=>{
    arrow.style.display = "none";
  });
}

// When the page loaded
window.onload = (event) => {
  document.getElementById('searchQR').value = '';
  arrow.style.display = "none";
};

function check(aTag)
{
    var id = document.getElementById("searchQR").value;
    aTag.href = "view/result?qr_key=" + id;
    return true;
}


// Tabs
let tabHeaders = document.querySelectorAll(".tabs .tab-header > div");
let tabContents = document.querySelectorAll(".tabs .tab-body > div");
let tabIndicator = document.getElementsByClassName("tab-indicator")[0];

for(let i = 0; i < tabHeaders.length; i++){
  tabHeaders[i].addEventListener("click", function(){
    document.querySelector(".tabs .tab-header > .active_tab").classList.remove("active_tab");
    tabHeaders[i].classList.add("active_tab");
    document.querySelector(".tabs .tab-body > .active_tab").classList.remove("active_tab");
    tabContents[i].classList.add("active_tab");

    tabIndicator.style.left = `calc(calc(100% / 2) * ${i})`;
  })
}


// Visitor per timeslot validation
function validateVisitor()
{
  var visitor = document.getElementById("visitor");

  if (visitor.value < 5 || visitor.value > 10)
  {
    alert("Sorry, the value you inputted is invalid." +
      " The minimum number of visitors per timeslot is one (1) person," +
      " and the maximum number of visitors per timeslot is nine (9) persons.");

    // Change the value back to the previous valid answer
    visitor.value = "1";
    return false;
  }
}

// Span of open days to reschedule validation
function validateResched()
{
  var days_resched = document.getElementById("days_resched");

  if (days_resched.value < 1 || days_resched.value > 5)
  {
    alert("Sorry, the value you inputted is invalid." +
      " The minimum span of open days to reschedule an appointment is one (1) day," +
      " and the maximum span of open days is five (5) days.");

    // Change the value back to the previous valid answer
    days_resched.value = "1";
    return false;
  }
}

// Number of days open for scheduling validation
function validateDays()
{
  var days_span = document.getElementById("days_span");

  if (days_span.value < 15 || days_span.value > 90)
  {
    alert("Sorry, the value you inputted is invalid." +
      " The minimum number of open days for scheduling an appointment is fifteen (15) day," +
      " and the maximum number of open days is ninety (90) days.");

    // Change the value back to the previous valid answer
    days_span.value = "1";
    return false;
  }
}

// Span of hours the timeslot is open for scheduling validation
function validateHours()
{
  var hours_span = document.getElementById("hours_span");

  if (hours_span.value < 1 || hours_span.value > 24)
  {
    alert("Sorry, the value you inputted is invalid." +
      " The minimum span of hours the timeslot is open for scheduling is one (1) day," +
      " and the maximum span of hours is twenty-four (24) hours.");

    // Change the value back to the previous valid answer
    hours_span.value = "1";
    return false;
  }
}


// Edit username
( function() { // javascript document ready function
  var visitor = document.getElementById("visitor");
  var days_resched = document.getElementById("days_resched");
  var days_span = document.getElementById("days_span");
  var hours_span = document.getElementById("hours_span");
  var submitBtn = document.getElementById("submitBtn");
  var form_mtn = document.getElementById("frm-mntn");

  var toggle_btn = document.getElementById("toggle-btn");

  if(toggle_btn.checked == true) {
    visitor.disabled = "";
    days_resched.disabled = "";
    days_span.disabled = "";
    hours_span.disabled = "";

    submitBtn.disabled = false;
  } else {
    visitor.disabled = true;
    days_resched.disabled = true;
    days_span.disabled = true;
    hours_span.disabled = true;

    submitBtn.disabled = true;
  }

  toggle_btn.addEventListener("click", function(){
    if(toggle_btn.checked == true) {

      Fnon.Ask.Dark({
        message: 'Are you sure to turn on maintenance mode? All users except system administrators will be prohibited to use the system.',
        title: 'Maintenance Mode',
        btnOkText: 'Yes',
        fontFamily: 'Poppins, sans-serif',
        btnCancelText: 'Cancel', 
          callback: (result)=>{
            if(result) {
              var tmpSubmit = document.createElement('button');
              tmpSubmit.name = "set_mtn";
              form_mtn.appendChild(tmpSubmit);
              tmpSubmit.click();
              form_mtn.removeChild(tmpSubmit);
            } else {
              toggle_btn.checked = false;
            }
          }
      }); 

      
    }

    else {
      var tmpSubmit = document.createElement('button');
      tmpSubmit.name = "set_mtn";
      form_mtn.appendChild(tmpSubmit);
      tmpSubmit.click();
      form_mtn.removeChild(tmpSubmit);

      visitor.disabled = "disabled";
      days_resched.disabled = "disabled";
      days_span.disabled = "disabled";
      hours_span.disabled = "disabled";



      submitBtn.disabled = "disabled";
  
      if(visitor.value) {
        localStorage.setItem(visitor.getAttribute("id"), visitor.value); // saving data to local storage
      }

      if(days_resched.value) {
        localStorage.setItem(days_resched.getAttribute("id"), days_resched.value); // saving data to local storage
      }

      if(days_span.value) {
        localStorage.setItem(days_span.getAttribute("id"), days_span.value); // saving data to local storage
      }

      if(hours_span.value) {
        localStorage.setItem(hours_span.getAttribute("id"), hours_span.value); // saving data to local storage
      }
    }
  });
} )();


// Edit username
( function() { // javascript document ready function
  var username = document.getElementById( 'username' );
  var editBtn = document.getElementById("editBtn");
  username.disabled = true;

  editBtn.addEventListener("click", function(){
    if(username.disabled) {
      username.style.borderBottom = "2px solid #EAB800";
      editBtn.type = "button";
      editBtn.innerHTML = "<i class='bi bi-save' aria-hidden='true'></i>" + " Save Changes";
      editBtn.disabled = true;
      username.readOnly = false;
      username.disabled = false;
    }

    else {
      username.readOnly = true;
      username.style.borderBottom = "none";
      editBtn.type = "submit";
      editBtn.innerHTML = "<i class='bi bi-pen' aria-hidden='true'></i>" + " Edit Username";

      if(username.value) {
        localStorage.setItem(username.getAttribute("id"), username.value); // saving data to local storage
      }
    }
  });
} )();


// Username Strength Checker
var getUsername=document.getElementById('username');

// Showing the Password Strength Checker
getUsername.onfocus=function(){
  document.getElementById('Umess').style.display='block';
}

// Hiding the Password Strength Checker
getUsername.onblur=function(){
  document.getElementById('Umess').style.display='none';
}

// Checking the new password strength
getUsername.onkeyup=function() {
  if (getUsername.value.match(/[A-Z]/g)) {
    document.getElementById("upperU").style.color='green';
  }

  else {
    document.getElementById("upperU").style.color='grey';
    getUsername.style.borderBottom = "2px solid #B22222";  
  }

  if (getUsername.value.match(/[a-z]/g)) {
    document.getElementById("lowerU").style.color='green';
  }

  else {
    document.getElementById("lowerU").style.color='grey';
    getUsername.style.borderBottom = "2px solid #B22222";
  }

  if (getUsername.value.match(/[0-9]/g)) {
    document.getElementById("digitU").style.color='green';
  }

  else {
    document.getElementById("digitU").style.color='grey';
    getUsername.style.borderBottom = "2px solid #B22222";   
  }

  if (getUsername.value.match(/[^a-zA-Z\d]/g)) {
    document.getElementById("specialU").style.color='green';
  }

  else {
    document.getElementById("specialU").style.color='grey';  
    getUsername.style.borderBottom = "2px solid #B22222";
  }

  if (getUsername.value.length>=12) {
    document.getElementById("lenU").style.color='green';    
  }

  else {
    document.getElementById("lenU").style.color='grey';   
  }

  if (getUsername.value.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z\d])(?=.{12,})/gm)) {
    getUsername.style.borderBottom = "2px solid green";
    editBtn.disabled = false;
  }

  else {  
    getUsername.style.borderBottom = "2px solid #B22222";
  }
}


// Change password
let changeBtn = document.querySelector("#changeBtn");
let changeForm = document.querySelector("#change_pass_form");
let cancelBtn = document.querySelector("#cancelBtn");
let submtBtn = document.querySelector("#submtBtn");

submtBtn.disabled = true;

changeBtn.addEventListener("click", function(event) {
  changeForm.style.display = "block";
});

cancelBtn.addEventListener("click", function(event) {
  let currentPassword = document.querySelector("#currentPassword");
  let newPassword = document.querySelector("#newPassword");
  let confirmNewPassword = document.querySelector("#cNewPassword");
  let alertMessage = document.querySelector("#alertMessage");

  changeForm.style.display = "none";
  currentPassword.style.borderBottom = "2px solid #D0CECE";
  newPassword.style.borderBottom = "2px solid #D0CECE";
  confirmNewPassword.style.borderBottom = "2px solid #D0CECE";
  alertMessage.innerHTML = "";
});


// Showing the Current Password
var state = false;
let hide = document.querySelector("#show1");

function toggle1() {
  if (state) {
    document.getElementById("currentPassword").setAttribute("type", "password");
    hide.style.color = "#D0CECE";
    hide.classList.replace("bi-eye-slash", "bi-eye");
    state = false;
  }

  else {
    document.getElementById("currentPassword").setAttribute("type", "text");
    hide.style.color = "#1976D2";
    hide.classList.replace("bi-eye", "bi-eye-slash");
    state = true;
  }
}

var state2 = false;
let hide2 = document.querySelector("#show2");

function toggle2() {
  if (state2) {
    document.getElementById("newPassword").setAttribute("type", "password");
    hide2.style.color = "#D0CECE";
    hide2.classList.replace("bi-eye-slash", "bi-eye");
    state2 = false;
  }

  else {
    document.getElementById("newPassword").setAttribute("type", "text");
    hide2.style.color = "#1976D2";
    hide2.classList.replace("bi-eye", "bi-eye-slash");
    state2 = true;
  }
}

var state3 = false;
let hide3 = document.querySelector("#show3");

function toggle3() {
  if (state3) {
    document.getElementById("cNewPassword").setAttribute("type", "password");
    hide3.style.color = "#D0CECE";
    hide3.classList.replace("bi-eye-slash", "bi-eye");
    state3 = false;
  }

  else {
    document.getElementById("cNewPassword").setAttribute("type", "text");
    hide3.style.color = "#1976D2";
    hide3.classList.replace("bi-eye", "bi-eye-slash");
    state3 = true;
  }
}


// New Password Strength Checker
var getpassword=document.getElementById('newPassword');

// Showing the Password Strength Checker
getpassword.onfocus=function(){
  document.getElementById('mess').style.display='block';
}

// Hiding the Password Strength Checker
getpassword.onblur=function(){
  document.getElementById('mess').style.display='none';
}

// Checking the new password strength
function password(){
  if (getpassword.value.match(/[A-Z]/g)) {
    document.getElementById("upper").style.color='green';
  }

  else {
    document.getElementById("upper").style.color='grey';
    getpassword.style.borderBottom = "2px solid #B22222";  
  }

  if (getpassword.value.match(/[a-z]/g)) {
    document.getElementById("lower").style.color='green';
  }

  else {
    document.getElementById("lower").style.color='grey';
    getpassword.style.borderBottom = "2px solid #B22222";
  }

  if (getpassword.value.match(/[0-9]/g)) {
    document.getElementById("digit").style.color='green';
  }

  else {
    document.getElementById("digit").style.color='grey';
    getpassword.style.borderBottom = "2px solid #B22222";   
  }

  if (getpassword.value.match(/[^a-zA-Z\d]/g)) {
    document.getElementById("special").style.color='green';
  }

  else {
    document.getElementById("special").style.color='grey';  
    getpassword.style.borderBottom = "2px solid #B22222";
  }

  if (getpassword.value.length>=12) {
    document.getElementById("len").style.color='green';    
  }

  else {
    document.getElementById("len").style.color='grey';   
  }

  if (getpassword.value.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z\d])(?=.{8,})/gm)) {
    getpassword.style.borderBottom = "2px solid green";
    submtBtn.disabled = false;
  }

  else {  
    getpassword.style.borderBottom = "2px solid #B22222";
  }
}


// Checks if new password and confirm password matched
function valid() {
  var newPassword = document.getElementById("newPassword").value;
  var confirmPassword = document.getElementById("cNewPassword").value;
  var conPass = document.getElementById("cNewPassword");

  var alertMessage = document.getElementById("alertMessage");

  if (newPassword == '') {
    alertMessage.innerHTML = "Please enter new password first"
    alertMessage.style.color = "#B22222";
    conPass.style.borderBottom = "2px solid #B22222";
  }

  else if (confirmPassword == '') {
    alertMessage.innerHTML = "Please re-enter new password"
    alertMessage.style.color = "#B22222";
    conPass.style.borderBottom = "2px solid #B22222";
  }

  else if (newPassword != confirmPassword) {
    alertMessage.innerHTML = "Password didn't match";
    alertMessage.style.color = "#B22222";
    conPass.style.borderBottom = "2px solid #B22222";
    submtBtn.disabled = true;
  }

  else {
    alertMessage.innerHTML = "Password match"
    alertMessage.style.color = "green";
    conPass.style.borderBottom = "2px solid green";
    submtBtn.disabled = false;
  }
}