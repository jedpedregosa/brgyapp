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

function check(aTag)
{
    var id = document.getElementById("searchQR").value;
    aTag.href = "view/result?qr_key=" + id;
    return true;
}

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