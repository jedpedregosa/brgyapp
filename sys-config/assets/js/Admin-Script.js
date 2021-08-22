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
  let oempt = document.getElementById('office-empt');

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
            oempt.style.display = "none";
          },
          success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
          }
      }).done(function(dataResult) {
          owait.style.display = "none";
          var available_offices = JSON.parse(dataResult);

          if(available_offices.length > 0) {
            for(let i = 0; i < available_offices.length; i++) {
              var opt = document.createElement('option');
              opt.value = available_offices[i][0];
              opt.innerHTML = available_offices[i][1];
              office_select.appendChild(opt);
              office_select.disabled = false;
            }

            office_select.style.display = "inline";
          } else {
            oempt.style.display = "inline";
            office_select.style.display = "none";
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

function confirmODelete(off_id, off_name, off_camp) {
  Fnon.Ask.Warning({
    message: 'Are you sure to delete' +
    ' <strong>' + off_name + '</strong>, <strong> '+ off_camp +'</strong>? This cannot be undone.',
    title: 'Confirm Delete',
    btnOkText: 'Yes',
    titleBackground: '#002060',
		titleColor: 'White',
    fontFamily: 'Poppins, sans-serif',
    btnCancelText: 'Cancel', 
      callback: (result)=>{
        if(result) {
          window.location.href = "../controllers/del-office?off_id=" + off_id;
        } 
      }
  }); 
}

function confirmAdmDel(adm_id, adm_name) {
  Fnon.Ask.Warning({
    message: 'Are you sure to delete' +
    ' office admin <strong>' + adm_name + ' (' + adm_id+ ')</strong>? This cannot be undone.',
    title: 'Confirm Delete',
    btnOkText: 'Yes',
    titleBackground: '#002060',
		titleColor: 'White',
    fontFamily: 'Poppins, sans-serif',
    btnCancelText: 'Cancel', 
      callback: (result)=>{
        if(result) {
          window.location.href = "../controllers/del-admin?adm_id=" + adm_id;
        } 
      }
  }); 
}

function editOffice(off_id, off_name, off_desc, accepts) {
  
  document.getElementById('editoffid').value = off_id;
  document.getElementById('editoffn').value = off_name;
  document.getElementById('editoffdsc').value = off_desc;
  document.getElementById('editaccept').checked = accepts;

  document.getElementById('id11').style.display='block';
}

function editAdmin(adm_id, lname, fname, email, contact) {
  
  document.getElementById('editadmid').value = adm_id;
  document.getElementById('editadmlname').value = lname;
  document.getElementById('editadmfname').value = fname;
  document.getElementById('editadmail').value = email;
  document.getElementById('editadmcntct').value = contact;

  document.getElementById('id12').style.display='block'
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

function check(aTag, from)
{
    var id = document.getElementById("searchQR").value;
    if(from == 1) { 
      aTag.href = "result?qr_key=" + id;
    } else {
      aTag.href = "view/result?qr_key=" + id;
    }
    return true;
}