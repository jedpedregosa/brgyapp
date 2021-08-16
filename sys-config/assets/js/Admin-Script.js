// OFFICES
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

// OFFICES
const selected = document.querySelector(".selected");
const optionsContainer = document.querySelector(".options-container");

const optionsList = document.querySelectorAll(".option");

selected.addEventListener("click", () => {
    optionsContainer.classList.toggle("active");
});

optionsList.forEach(o => {
    o.addEventListener("click", () => {
        selected.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer.classList.remove("active");
    });
});

const selected1 = document.querySelector(".selected1");
const optionsContainer1 = document.querySelector(".options-container1");

const optionsList1 = document.querySelectorAll(".option1");

selected1.addEventListener("click", () => {
    optionsContainer1.classList.toggle("active");
});

optionsList1.forEach(o => {
    o.addEventListener("click", () => {
        selected1.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer1.classList.remove("active");
    });
});

function loadOffices() {
  var branch = document.getElementById('oa-branch').value;
  var office_select = document.getElementById('oa-office');

  let owait = document.getElementById('office-wait');
  let onone = document.getElementById('office-none');

  office_select.innerHTML = "";
  
  if(branch != "") {
      $.ajax({
          url: "../controllers/load-open-office",
          type: "POST",
          data: {
              branch: branch,
          },
          cache: false,
          beforeSend: function(){
            owait.style.display = "inline";
            onone.style.display = "none";
          },
          success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
          }
      }).done(function(dataResult) {
          owait.style.display = "none";
          office_select.style.display = "inline";
          var available_offices = JSON.parse(dataResult);

          for(let i = 0; i < available_offices.length; i++) {
              var opt = document.createElement('option');
              opt.value = available_offices[i][0];
              opt.innerHTML = available_offices[i][1];
              office_select.appendChild(opt);
              office_select.disabled = false;
          }
      });
  }
}

function searchTableAdmin(field, txt_value) {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = txt_value;
  filter = input.toUpperCase();
  table = document.getElementById("tbl_admin");
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

function searchTableOffice(field, txt_value) {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = txt_value;
  filter = input.toUpperCase();
  table = document.getElementById("tbl_office");
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