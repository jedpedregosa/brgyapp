// RTU APPOINTMENT SYSTEM - ADMINISTRATOR

// JS for Side Navigation Bar
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".qr");
// Displaying arrow when typing
let arrow = document.querySelector("#arrow");

// When the page loaded
window.onload = () => {
  document.getElementById('searchQR').value = '';
  arrow.style.display = "none";
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
    aTag.href = "result?qr_key=" + id;
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

function sortTable(id) {
  let optn = id.value;
  let optn_stmp = document.getElementById("slct_tmestmp").value;

  if(optn) {
    if(optn_stmp) {
      window.location.href = "appointment?class=" + optn + "&by=" + optn_stmp;
    } else {
      window.location.href = "appointment?class=" + optn;
    }
  } else {
    if(optn_stmp) {
      window.location.href = "appointment" + "?by=" + optn_stmp;
    } else {
      window.location.href = "appointment";
    }
  }
  
}
function sortTableBy(id) {
  let optn_stmp = id.value;
  let optn = document.getElementById("slct_class").value;

  if(optn_stmp) {
    if(optn) {
      window.location.href = "appointment" + "?by=" + optn_stmp + "&class=" + optn;
    } else {
      window.location.href = "appointment" + "?by=" + optn_stmp;
    }
  } else {
    if(optn) {
      window.location.href = "appointment" + "?class=" + optn;
    } else {
      window.location.href = "appointment";
    }
  }
}

function searchTable(field, txt_value) {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("txt_search");
  filter = input.value.toUpperCase();
  table = document.getElementById("tbl_appointments");
  tr = table.getElementsByTagName("tr");
  
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[field];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function searchTableFeedback(field, txt_value) {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = txt_value;
  filter = input.toUpperCase();
  table = document.getElementById("tbl_fback");
  tr = table.getElementsByTagName("tr");
  
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[field];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}