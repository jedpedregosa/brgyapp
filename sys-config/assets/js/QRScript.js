// RTU APPOINTMENT SYSTEM - ADMINISTRATOR

// JS for Side Navigation Bar
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bi-arrow-left-circle");
let form_done = document.querySelector('#frm_done');

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
});

