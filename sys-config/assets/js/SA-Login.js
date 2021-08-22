 // Showing the Current Password
var state = false;

let hide = document.querySelector("#togglePassword");

function toggle() {
  if (state) {
    document.getElementById("password").setAttribute("type", "password");
    document.getElementById('togglePassword').style.color = "#D0CECE";
    hide.classList.replace("bi-eye-slash", "bi-eye");
    state = false;
  }

  else {
    document.getElementById("password").setAttribute("type", "text");
    document.getElementById('togglePassword').style.color = "#1976D2";
    hide.classList.replace("bi-eye", "bi-eye-slash");
    state = true;
  }
}
