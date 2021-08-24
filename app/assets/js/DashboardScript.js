// RTU APPOINTMENT SYSTEM - ADMINISTRATOR

// JS for Side Navigation Bar
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let submit_close = document.querySelector("#save");
let form_close_schd = document.querySelector('#form_close_sched');
let searchBtn = document.querySelector(".qr");
// Displaying arrow when typing
let arrow = document.querySelector("#arrow");

// When the page loaded
window.onload = () => {
  document.getElementById('searchQR').value = '';
  arrow.style.display = "none";
  initClock();
};


closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)
});

searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search icon
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

submit_close.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
  if (!form_close_schd.checkValidity()) {
    var tmpSubmit = document.createElement('button');
    form_close_schd.appendChild(tmpSubmit);
    tmpSubmit.click();
    form_close_schd.removeChild(tmpSubmit);
  } else {
    Fnon.Ask.Warning({
      message:'Are you sure? You cannot undo this process anymore.',
      title: 'Closing of Schedule',
      titleColor: 'White',
      btnOkText: 'Continue',
      titleBackground: '#002060',
      fontFamily: 'Poppins, sans-serif',
      btnCancelText: 'Cancel', 
      callback: (result)=>{
        if(result) {
          var tmpSubmit = document.createElement('button');
          tmpSubmit.name = "close_sched_upd";
          form_close_schd.appendChild(tmpSubmit);
          tmpSubmit.click();
          form_close_schd.removeChild(tmpSubmit);
        } 
      }
    });
  }
});


