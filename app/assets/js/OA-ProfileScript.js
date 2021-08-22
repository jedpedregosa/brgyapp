// RTU APPOINTMENT SYSTEM - ADMINISTRATOR

// JS for Side Navigation Bar
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let form_upload = document.querySelector("#form_upload");
let searchBtn = document.querySelector(".qr");
// Displaying arrow when typing
let arrow = document.querySelector("#arrow");

// When the page loaded
window.onload = () => {
  document.getElementById('searchQR').value = '';
  arrow.style.display = "none";
  document.getElementById("upd_pass").disabled = true;
  
};

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)
});

searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});

function check(aTag)
{
    var id = document.getElementById("searchQR").value;
    aTag.href = "view/result?qr_key=" + id;
    return true;
}

function Typing() {
  arrow.style.display = "block";
  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search icon
    arrow.style.display = "none";
  });
  closeBtn.addEventListener("click", ()=>{
    arrow.style.display = "none";
  });
}

// Upload Profile Picture
const imgDiv = document.querySelector(".profile-user-con");
const img = document.querySelector("#profile-photo");
const file = document.querySelector("#file");
const uploadBtn = document.querySelector("#uploadBtn");

// Hover on profile container

// Hover on
imgDiv.addEventListener('mouseenter', function()
{
  uploadBtn.style.display = "block"
});

// Hover out
imgDiv.addEventListener('mouseleave', function()
{
  uploadBtn.style.display = "none"
});

// Profile Image display
file.addEventListener('change', function()
{
  var tmpSubmit = document.createElement('button');
  tmpSubmit.name = "upload";
  form_upload.appendChild(tmpSubmit);
  tmpSubmit.click();
  form_upload.removeChild(tmpSubmit);

  const choosedFile = this.files[0];

  if (choosedFile) {
    const reader = new FileReader();

    reader.addEventListener('load', function()
    {
      img.setAttribute('src', reader.result);
    });

    reader.readAsDataURL(choosedFile);
  }
});

// Header Profile Image Display
const img2 = document.querySelector("#header-pic");

file.addEventListener('change', function()
{
  const choosedFile = this.files[0];

  if (choosedFile) {
    const reader = new FileReader();

    reader.addEventListener('load', function()
    {
      img2.setAttribute('src', reader.result);
    });

    reader.readAsDataURL(choosedFile);
  }
});

// Side Navigation Bar Image Display
const img3 = document.querySelector("#bar-pic");

file.addEventListener('change', function()
{
  const choosedFile = this.files[0];

  if (choosedFile) {
    const reader = new FileReader();

    reader.addEventListener('load', function()
    {
      img3.setAttribute('src', reader.result);
    });

    reader.readAsDataURL(choosedFile);
  }
});



// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
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

// Checking the Strength
function password(){
  document.getElementById("upd_pass").disabled = true;
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

  if (getpassword.value.length>=8) {
    document.getElementById("len").style.color='green';
  }

  else {
    document.getElementById("len").style.color='grey';    
  }

  if (getpassword.value.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z\d])(?=.{8,})/gm)) {
    document.getElementById("upd_pass").disabled = false;
    getpassword.style.borderBottom = "2px solid green";
  }

  else {  
    getpassword.style.borderBottom = "2px solid #B22222";
  }
}


// Showing the Current Password
var state = false;
let hide = document.querySelector("#eye1");

function toggle1() {
  if (state) {
    document.getElementById("currentPassword").setAttribute("type", "password");
    document.getElementById('eye1').style.color = "#D0CECE";
    hide.classList.replace("bi-eye-slash", "bi-eye");
    state = false;
  }

  else {
    document.getElementById("currentPassword").setAttribute("type", "text");
    document.getElementById('eye1').style.color = "#1976D2";
    hide.classList.replace("bi-eye", "bi-eye-slash");
    state = true;
  }
}

// Showing the New Password
let hide2 = document.querySelector("#eye2");

function toggle2() {
  if (state) {
    document.getElementById("newPassword").setAttribute("type", "password");
    document.getElementById('eye2').style.color = "#D0CECE";
    hide2.classList.replace("bi-eye-slash", "bi-eye");
    state = false;
  }

  else {
    document.getElementById("newPassword").setAttribute("type", "text");
    document.getElementById('eye2').style.color = "#1976D2";
    hide2.classList.replace("bi-eye", "bi-eye-slash");
    state = true;
  }
}

// Showing the Confirm New Password
let hide3 = document.querySelector("#eye3");

function toggle3() {
  if (state) {
    document.getElementById("cNewPassword").setAttribute("type", "password");
    document.getElementById('eye3').style.color = "#D0CECE";
    hide3.classList.replace("bi-eye-slash", "bi-eye");
    state = false;
  }

  else {
    document.getElementById("cNewPassword").setAttribute("type", "text");
    document.getElementById('eye3').style.color = "#1976D2";
    hide3.classList.replace("bi-eye", "bi-eye-slash");
    state = true;
  }
}


// Checks if new password and confirm password matched
function valid() {
  var newPassword = document.getElementById("newPassword").value;
  var confirmPassword = document.getElementById("cNewPassword").value;
  var conPass = document.getElementById("cNewPassword");
  document.getElementById("upd_pass").disabled = true;

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
  }

  else {
    document.getElementById("upd_pass").disabled = false;
    alertMessage.innerHTML = "Password match"
    alertMessage.style.color = "green";
    conPass.style.borderBottom = "2px solid green";
  }
}


//input fields
const first_name = document.getElementById('first-name');
const last_name = document.getElementById('last-name');
const email_address = document.getElementById('email-address');
const contact_number = document.getElementById('contact-number');

//err0r-labels
const error_first_name = document.getElementById('error-first-name');
const error_last_name = document.getElementById('error-last-name');
const error_email_address = document.getElementById('error-email-address');
const error_contact_number = document.getElementById('error-contact-number');

var wordRegex = /^[a-zA-Z ]*$/;
var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
var numberRegex = /^[0-9-+]*$/;

function isFormValidated() {
    return isFirstNameValid() && isLastNameValid() && isEmailValid() && isContactValid();
}
function isFirstNameValid() {
    if(first_name.value == null || first_name.value == ''){
        error_first_name.textContent = "Please fill up this field";
    } else if (!first_name.value.match(wordRegex) || first_name.value.length < 2){
        error_first_name.textContent = "Invalid First Name";
    } else{
        error_first_name.textContent ="";
        return true;
    }
    return false;
}

function isLastNameValid() {
    if(last_name.value == null || last_name.value == ''){
        error_last_name.textContent = "Please fill up this field";
    } else if (!last_name.value.match(wordRegex) || last_name.value.length < 2){
        error_last_name.textContent = "Invalid Last Name";
    } else{
        error_last_name.textContent="";
        return true;
    }
    return false;
}

function isEmailValid() {
    if(email_address.value == null || email_address.value == ''){
        error_email_address.textContent = "Please fill up this field";
    } else if (!email_address.value.match(emailRegex) || email_address.value.length < 2){
        error_email_address.textContent = "Invalid Email Address";
    } else {
        if(error_email_address) {
            error_email_address.textContent="";
        }
        return true;
    }
    return false;
}

function isContactValid() {
    if(contact_number.value == null || contact_number.value == ''){
        error_contact_number.textContent = "Please fill up this field";
    } else if (!contact_number.value.match(numberRegex) || contact_number.value.length > 15 || contact_number.value.length < 6){
        error_contact_number.textContent = "Invalid Contact Number";
    } else{
        error_contact_number.textContent="";
        return true;
    }
    return false;
}

first_name.addEventListener("keyup", function(event){
    isFirstNameValid();
});

last_name.addEventListener("keyup", function(event){
    isLastNameValid();
});

email_address.addEventListener("keyup", function(event){
    isEmailValid();
});

contact_number.addEventListener("keyup", function(event){
    isContactValid();
});
