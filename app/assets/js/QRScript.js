// RTU APPOINTMENT SYSTEM - ADMINISTRATOR

// JS for Side Navigation Bar
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bi-arrow-left-circle");
let form_done = document.querySelector('#frm_done');

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
  done.style.color = "#181717";
  state = false;

  Fnon.Ask.Warning({
    message:'Are you sure? This process cannot be undone.',
    title: 'Appointment',
    titleColor: 'White',
    btnOkText: 'Continue',
    titleBackground: '#002060',
    fontFamily: 'Poppins, sans-serif',
    btnCancelText: 'Cancel', 
    callback: (result)=>{
      if(result) {
        var tmpSubmit = document.createElement('button');
        tmpSubmit.name = "app_done";
        form_done.appendChild(tmpSubmit);
        tmpSubmit.click();
        form_done.removeChild(tmpSubmit);
      } else {
        done.style.color = "#EAB800";
        state = true;
      }
    }
  });
}