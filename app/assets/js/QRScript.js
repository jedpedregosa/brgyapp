// RTU APPOINTMENT SYSTEM - ADMINISTRATOR

// JS for Side Navigation Bar
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bi-arrow-left-circle");

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
});


// Changing the Button Icon of Appointment Done
document.getElementById("doneBtn").addEventListener("click", function (e) {
  var target = e.target;
  target.classList.toggle("bi-circle");
  target.classList.toggle("bi-check-circle");
}, false);


// Changing the button text color
var state = false;
let done = document.querySelector("#doneBtn")

function doneBtnChange() {
  if (state) {
    done.style.color = "#181717";
    state = false;
  }

  else {
    done.style.color = "#EAB800";
    state = true;
  }
}